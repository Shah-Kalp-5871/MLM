use App\Models\User;
use App\Models\Investment;
use App\Models\ROIIncome;
use App\Models\Wallet;
use App\Services\InvestmentService;
use Illuminate\Support\Facades\DB;

$service = app(InvestmentService::class);

echo "--- MLM DYNAMIC DEPTH VERIFICATION ---\n";

DB::transaction(function() use ($service) {
    // Clear existing test users
    User::where('email', 'like', 'test%')->delete();
    User::where('email', 'like', 'direct%')->delete();

    // 1. Setup Chain: A -> B -> C -> D -> E
    // Levels from E's perspective: D=1, C=2, B=3, A=4
    $a = User::create(['name' => 'Test A', 'email' => 'testA@example.com', 'password' => 'pass', 'referral_code' => 'A1']);
    $b = User::create(['name' => 'Test B', 'email' => 'testB@example.com', 'password' => 'pass', 'referral_code' => 'B1', 'upline_id' => $a->id]);
    $c = User::create(['name' => 'Test C', 'email' => 'testC@example.com', 'password' => 'pass', 'referral_code' => 'C1', 'upline_id' => $b->id]);
    $d = User::create(['name' => 'Test D', 'email' => 'testD@example.com', 'password' => 'pass', 'referral_code' => 'D1', 'upline_id' => $c->id]);
    $e = User::create(['name' => 'Test E', 'email' => 'testE@example.com', 'password' => 'pass', 'referral_code' => 'E1', 'upline_id' => $d->id]);

    Wallet::create(['user_id' => $a->id, 'balance' => 0]);
    Wallet::create(['user_id' => $b->id, 'balance' => 0]);
    Wallet::create(['user_id' => $c->id, 'balance' => 0]);
    Wallet::create(['user_id' => $d->id, 'balance' => 0]);
    Wallet::create(['user_id' => $e->id, 'balance' => 0]);

    // A needs $500 investment to be qualified at all
    $a->investments()->create(['amount' => 500, 'status' => 'active', 'weekly_roi_percentage' => 3, 'next_payout_at' => now()->addDays(7)]);
    // E also needs $500 to count for uplines
    $e->investments()->create(['amount' => 500, 'status' => 'active', 'weekly_roi_percentage' => 3, 'next_payout_at' => now()->addDays(7)]);

    // --- TEST CASE 1: A has only 1 direct (B) ---
    // A's eligible depth is 1. E is at level 4.
    echo "\nTEST 1: A has 1 direct (B). E is Level 4.\n";
    echo "A Eligible Depth: " . $a->getEligibleDepth() . "\n";
    $service->distributeBusiness($e->id, 1000);
    $a->refresh();
    echo "A Team Business: $" . $a->team_business . " (Expected: 0)\n";

    // --- TEST CASE 2: A has 4 directs ---
    // A's eligible depth is now 4. E is at level 4.
    echo "\nTEST 2: A has 4 directs. E is Level 4.\n";
    for($i=1; $i<=3; $i++) {
        $u = User::create(['name' => "Direct $i", 'email' => "direct$i@example.com", 'password' => 'pass', 'referral_code' => "D$i", 'upline_id' => $a->id]);
        $u->investments()->create(['amount' => 500, 'status' => 'active', 'weekly_roi_percentage' => 3, 'next_payout_at' => now()->addDays(7)]);
    }
    $a->refresh();
    echo "A Eligible Depth: " . $a->getEligibleDepth() . "\n";
    $service->distributeBusiness($e->id, 1000);
    $a->refresh();
    echo "A Team Business: $" . $a->team_business . " (Expected: 1000)\n";

    // --- TEST CASE 3: Level Income Distribution ---
    echo "\nTEST 3: Level Income Distribution (A has depth 4, E is Level 4)\n";
    $roi = ROIIncome::create([
        'user_id' => $e->id,
        'investment_id' => 1, // dummy
        'week_key' => '2026-W01',
        'roi_percentage' => 3,
        'roi_amount' => 100,
        'distributed_at' => now()
    ]);
    $service->distributeROICommissions($roi);
    $a->refresh();
    $commission = $a->levelCommissions()->where('from_user_id', $e->id)->first();
    echo "A Level Commission: " . ($commission ? '$'.$commission->commission_amount : 'None') . " (Expected: > 0)\n";

    // --- TEST CASE 4: Level Income Restricted ---
    // A now has depth 4. Let's create user F at level 5 for A.
    echo "\nTEST 4: Level Income Restricted (A has depth 4, F is Level 5)\n";
    $f = User::create(['name' => 'Test F', 'email' => 'testF@example.com', 'password' => 'pass', 'referral_code' => 'F1', 'upline_id' => $e->id]);
    Wallet::create(['user_id' => $f->id, 'balance' => 0]);
    $roiF = ROIIncome::create([
        'user_id' => $f->id,
        'investment_id' => 1,
        'week_key' => '2026-W02',
        'roi_percentage' => 3,
        'roi_amount' => 100,
        'distributed_at' => now()
    ]);
    $service->distributeROICommissions($roiF);
    $a->refresh();
    $commissionF = $a->levelCommissions()->where('from_user_id', $f->id)->first();
    echo "A Level Commission from F: " . ($commissionF ? '$'.$commissionF->commission_amount : 'None') . " (Expected: None)\n";

    throw new Exception("Rollback for clean database");
});
