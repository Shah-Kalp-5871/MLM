<?php

// ============================================================
// MLM Full Database Migration Generator
// ============================================================

$baseDir = __DIR__ . '/migrations';

$migrations = [];

// ────────────────────────────────────────────────────────────
// 1. MODIFY USERS TABLE (add MLM fields)
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000001_modify_users_table_mlm_fields.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('referral_code', 20)->unique()->nullable()->after('phone');
            $table->unsignedBigInteger('upline_id')->nullable()->after('referral_code');
            $table->enum('status', ['active', 'blocked', 'pending'])->default('pending')->after('upline_id');
            $table->timestamp('joined_at')->nullable()->after('status');
            $table->softDeletes();
            $table->index('upline_id');
            $table->index('referral_code');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone','referral_code','upline_id','status','joined_at','deleted_at']);
        });
    }
};
PHP;

// ────────────────────────────────────────────────────────────
// 2. ADMINS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000002_create_admins_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['super_admin', 'staff'])->default('staff');
            $table->boolean('status')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('admins'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 3. USER PROFILES TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000003_create_user_profiles_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable()->default('India');
            $table->string('profile_image')->nullable();
            // Payment details
            $table->string('bank_account_number', 30)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('ifsc_code', 15)->nullable();
            $table->string('upi_id', 100)->nullable();
            $table->string('wallet_address', 200)->nullable()->comment('USDT/Crypto address');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('user_profiles'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 4. REFERRALS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000004_create_referrals_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id');  // user who invited
            $table->unsignedBigInteger('referred_user_id');  // new user
            $table->boolean('has_invested')->default(false)->comment('Did referral make a deposit?');
            $table->timestamp('invested_at')->nullable();
            $table->timestamps();
            $table->foreign('referrer_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('referred_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index('referrer_id');
            $table->unique(['referrer_id', 'referred_user_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('referrals'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 5. MLM TREE TABLE (Closure Table for fast traversal)
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000005_create_mlm_tree_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlm_tree', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ancestor_id');   // upline
            $table->unsignedBigInteger('descendant_id'); // downline
            $table->unsignedSmallInteger('level');       // depth: 1=direct, 2=indirect, etc.
            $table->foreign('ancestor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('descendant_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index(['ancestor_id', 'level']);
            $table->index(['descendant_id']);
            $table->unique(['ancestor_id', 'descendant_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('mlm_tree'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 6. PACKAGES TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000006_create_packages_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);                              // Starter, Pro, Elite
            $table->decimal('price', 15, 2);                         // Minimum investment amount
            $table->decimal('roi_percentage', 5, 2);                 // Weekly ROI %
            $table->unsignedInteger('duration_weeks')->nullable();    // null = unlimited
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('packages'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 7. DEPOSITS TABLE (payment proofs pending admin approval)
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000007_create_deposits_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages');
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['usdt_trc20', 'bank_transfer', 'upi', 'internal_wallet'])->default('bank_transfer');
            $table->string('payment_proof')->nullable()->comment('File path for uploaded screenshot');
            $table->string('transaction_hash', 200)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('approved_by')->references('id')->on('admins')->nullOnDelete();
            $table->index('status');
        });
    }
    public function down(): void { Schema::dropIfExists('deposits'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 8. INVESTMENTS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000008_create_investments_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages');
            $table->foreignId('deposit_id')->constrained('deposits');
            $table->decimal('amount', 15, 2);
            $table->decimal('roi_percentage', 5, 2)->comment('Locked-in ROI% at time of investment');
            $table->date('roi_start_date');
            $table->date('roi_end_date')->nullable()->comment('Null = runs indefinitely');
            $table->unsignedInteger('total_roi_weeks_paid')->default(0);
            $table->enum('status', ['pending', 'active', 'expired', 'cancelled'])->default('pending');
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('investments'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 9. ROI INCOMES TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000009_create_roi_incomes_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('roi_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('investment_id')->constrained('investments')->cascadeOnDelete();
            $table->decimal('investment_amount', 15, 2);
            $table->decimal('roi_percentage', 5, 2);
            $table->decimal('roi_amount', 15, 2);
            $table->unsignedInteger('week_number');
            $table->date('for_week_ending');   // The week this payout covers
            $table->timestamp('distributed_at');
            $table->index(['user_id', 'for_week_ending']);
        });
    }
    public function down(): void { Schema::dropIfExists('roi_incomes'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 10. LEVEL SETTINGS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000010_create_level_settings_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('level_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('level')->unique();    // 1 to 15
            $table->decimal('percentage', 5, 2);               // Commission %
            $table->string('label', 100)->nullable();          // e.g. "Direct Referral"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('level_settings'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 11. LEVEL COMMISSIONS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000011_create_level_commissions_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('level_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver_id');       // Upline who gets the commission
            $table->unsignedBigInteger('from_user_id');      // Downline whose ROI triggered it
            $table->unsignedBigInteger('roi_income_id');     // Reference to the ROI payout
            $table->unsignedTinyInteger('level');             // 1–15
            $table->decimal('roi_amount', 15, 2);            // The downline's ROI amount
            $table->decimal('commission_percentage', 5, 2);  // % applied
            $table->decimal('commission_amount', 15, 2);     // Actual commission received
            $table->timestamp('created_at');
            $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('from_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('roi_income_id')->references('id')->on('roi_incomes')->cascadeOnDelete();
            $table->index(['receiver_id', 'level']);
            $table->index('created_at');
        });
    }
    public function down(): void { Schema::dropIfExists('level_commissions'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 12. WALLETS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000012_create_wallets_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('balance', 15, 2)->default(0.00)->comment('Cash balance (withdrawable)');
            $table->decimal('voucher_balance', 15, 2)->default(0.00)->comment('Non-withdrawable club voucher balance');
            $table->decimal('total_roi_earned', 15, 2)->default(0.00);
            $table->decimal('total_level_earned', 15, 2)->default(0.00);
            $table->decimal('total_withdrawn', 15, 2)->default(0.00);
            $table->decimal('total_deposited', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('wallets'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 13. WALLET TRANSACTIONS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000013_create_wallet_transactions_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'roi_income',
                'level_income',
                'deposit',
                'withdrawal',
                'voucher_awarded',
                'voucher_redeemed',
                'refund',
                'admin_credit',
                'admin_debit',
            ]);
            $table->enum('wallet', ['cash', 'voucher'])->default('cash');
            $table->decimal('amount', 15, 2);             // always positive
            $table->enum('direction', ['credit', 'debit']);
            $table->decimal('balance_after', 15, 2);      // snapshot after transaction
            $table->unsignedBigInteger('reference_id')->nullable();   // id in related table
            $table->string('reference_type', 100)->nullable();        // model name
            $table->string('description')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'type']);
            $table->index('created_at');
        });
    }
    public function down(): void { Schema::dropIfExists('wallet_transactions'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 14. WITHDRAWALS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000014_create_withdrawals_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0.00);
            $table->decimal('net_amount', 15, 2)->storedAs('amount - fee');
            $table->enum('payment_method', ['usdt_trc20', 'bank_transfer', 'upi'])->default('bank_transfer');
            $table->string('wallet_address', 200)->nullable();   // target address or bank details
            $table->string('transaction_id', 200)->nullable();   // admin fills after payment
            $table->enum('status', ['pending', 'processing', 'approved', 'paid', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('approved_by')->references('id')->on('admins')->nullOnDelete();
            $table->index(['user_id', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('withdrawals'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 15. CLUB MILESTONES TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000015_create_club_milestones_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('club_milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('tier')->unique();            // 1–7
            $table->string('name', 100);                              // e.g. "Silver Club"
            $table->decimal('direct_business_target', 15, 2);        // Direct deposit volume needed
            $table->decimal('team_business_target', 15, 2);          // Team deposit volume needed
            $table->decimal('voucher_value', 15, 2);                  // Reward value
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('club_milestones'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 16. CLUB QUALIFICATIONS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000016_create_club_qualifications_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('club_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('direct_business', 15, 2)->default(0.00);  // Sum of direct referral deposits
            $table->decimal('team_business', 15, 2)->default(0.00);    // Sum of all downline deposits
            $table->unsignedTinyInteger('current_tier')->default(0);   // Highest tier achieved (0 = none)
            $table->unsignedTinyInteger('highest_tier_achieved')->default(0);
            $table->timestamp('last_calculated_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('club_qualifications'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 17. CLUB REWARDS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000017_create_club_rewards_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('club_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('club_milestone_id')->constrained('club_milestones');
            $table->unsignedTinyInteger('tier');
            $table->decimal('reward_amount', 15, 2);
            $table->enum('status', ['awarded', 'assigned', 'redeemed', 'expired'])->default('awarded');
            $table->timestamp('awarded_at');
            $table->timestamps();
            $table->unique(['user_id', 'tier']); // Only one reward per tier per user
        });
    }
    public function down(): void { Schema::dropIfExists('club_rewards'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 18. VOUCHERS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000018_create_vouchers_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->decimal('value', 15, 2);
            $table->foreignId('club_reward_id')->nullable()->constrained('club_rewards')->nullOnDelete();
            $table->enum('status', ['unused', 'assigned', 'redeemed', 'expired'])->default('unused');
            $table->timestamp('expires_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->comment('Admin ID');
            $table->timestamps();
            $table->index('status');
        });
    }
    public function down(): void { Schema::dropIfExists('vouchers'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 19. VOUCHER ASSIGNMENTS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000019_create_voucher_assignments_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('voucher_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('assigned_at');
            $table->index('user_id');
        });
    }
    public function down(): void { Schema::dropIfExists('voucher_assignments'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 20. VOUCHER REDEMPTIONS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000020_create_voucher_redemptions_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('voucher_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_reference', 100)->nullable();
            $table->decimal('amount_used', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamp('redeemed_at');
            $table->index('user_id');
        });
    }
    public function down(): void { Schema::dropIfExists('voucher_redemptions'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 21. ACTIVITY LOGS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000021_create_activity_logs_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('action', 100);               // e.g. 'deposit.created', 'withdrawal.approved'
            $table->string('subject_type', 100)->nullable();  // model class
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at');
            $table->index(['user_id', 'action']);
            $table->index('created_at');
        });
    }
    public function down(): void { Schema::dropIfExists('activity_logs'); }
};
PHP;

// ────────────────────────────────────────────────────────────
// 22. SETTINGS TABLE
// ────────────────────────────────────────────────────────────
$migrations['2026_03_16_000022_create_settings_table.php'] = <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->string('type', 30)->default('string')->comment('string, integer, decimal, boolean, json');
            $table->string('group', 50)->default('general');
            $table->string('label', 200)->nullable();
            $table->boolean('is_public')->default(false)->comment('Visible to users?');
            $table->timestamps();
            $table->index('group');
        });
    }
    public function down(): void { Schema::dropIfExists('settings'); }
};
PHP;

// ─────────────────────────────────────────────────────────────────────────────
// WRITE ALL MIGRATION FILES
// ─────────────────────────────────────────────────────────────────────────────

$written = 0;
foreach ($migrations as $filename => $content) {
    $path = $baseDir . '/' . $filename;
    file_put_contents($path, $content);
    echo "  ✓ $filename\n";
    $written++;
}

echo "\n✅ $written migration files written to: $baseDir\n";
echo "\nNext step: php artisan migrate\n";
