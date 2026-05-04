<?php

namespace Tests\Feature;

use App\Models\Deposit;
use App\Models\Investment;
use App\Models\Setting;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\InvestmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvestmentApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_approval_creates_locked_investment_without_crediting_wallet(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0,
        ]);

        Setting::create([
            'key' => 'weekly_roi_percentage',
            'value' => '3.00',
            'type' => 'decimal',
            'group' => 'roi',
        ]);

        $deposit = Deposit::create([
            'user_id' => $user->id,
            'amount' => 5000,
            'payment_method' => 'usdt_trc20',
            'status' => 'pending',
        ]);

        $this->actingAs($admin);

        app(InvestmentService::class)->approveDepositAndInvest($deposit->id);

        $this->assertDatabaseHas('deposits', [
            'id' => $deposit->id,
            'status' => 'approved',
        ]);

        $this->assertDatabaseHas('investments', [
            'user_id' => $user->id,
            'amount' => 5000,
            'status' => 'active',
        ]);

        $this->assertSame(0.0, (float) Wallet::where('user_id', $user->id)->value('balance'));
        $this->assertSame(0, WalletTransaction::where('user_id', $user->id)->where('type', 'deposit')->count());
        $this->assertSame(5000.0, (float) Investment::where('user_id', $user->id)->sum('amount'));
    }
}
