<?php

namespace Tests\Feature;

use App\Models\Deposit;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FixWalletBalancesCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_dry_run_reports_traceable_bug_credit_without_changing_wallet(): void
    {
        $user = User::factory()->create();

        Wallet::create([
            'user_id' => $user->id,
            'balance' => 6000,
        ]);

        Deposit::create([
            'user_id' => $user->id,
            'amount' => 5000,
            'payment_method' => 'usdt_trc20',
            'status' => 'approved',
        ]);

        WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'deposit',
            'wallet' => 'cash',
            'amount' => 5000,
            'direction' => 'credit',
            'balance_after' => 5000,
            'description' => 'Funds credited via Usdt_trc20',
        ]);

        WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'roi_income',
            'wallet' => 'cash',
            'amount' => 1000,
            'direction' => 'credit',
            'balance_after' => 6000,
            'description' => 'Weekly ROI',
        ]);

        $this->artisan('fix:wallet --dry-run')
            ->expectsOutputToContain('Affected users: 1')
            ->expectsOutputToContain('Dry run only. No database changes were made.')
            ->assertExitCode(0);

        $this->assertSame(6000.0, (float) $user->wallet()->value('balance'));
    }

    public function test_execute_requires_force(): void
    {
        $this->artisan('fix:wallet --execute')
            ->expectsOutput('Execution is blocked until reviewed. Re-run with --execute --force.')
            ->assertExitCode(1);
    }

    public function test_execute_deducts_only_traceable_bug_credit_and_preserves_earnings(): void
    {
        $user = User::factory()->create();

        Wallet::create([
            'user_id' => $user->id,
            'balance' => 6000,
        ]);

        Deposit::create([
            'user_id' => $user->id,
            'amount' => 5000,
            'payment_method' => 'usdt_trc20',
            'status' => 'approved',
        ]);

        WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'deposit',
            'wallet' => 'cash',
            'amount' => 5000,
            'direction' => 'credit',
            'balance_after' => 5000,
            'description' => 'Funds credited via Usdt_trc20',
        ]);

        WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'level_income',
            'wallet' => 'cash',
            'amount' => 1000,
            'direction' => 'credit',
            'balance_after' => 6000,
            'description' => 'Level income',
        ]);

        $this->artisan('fix:wallet --execute --force')
            ->expectsOutputToContain('Corrected users: 1')
            ->expectsOutputToContain('Total corrected amount: 5000.00')
            ->assertExitCode(0);

        $this->assertSame(1000.0, (float) $user->wallet()->value('balance'));
        $this->assertDatabaseHas('wallet_transactions', [
            'user_id' => $user->id,
            'type' => 'admin_debit',
            'wallet' => 'cash',
            'amount' => 5000,
            'direction' => 'debit',
            'balance_after' => 1000,
        ]);
    }

    public function test_execute_skips_uncertain_wallet_without_traceable_bug_transaction(): void
    {
        $user = User::factory()->create();

        Wallet::create([
            'user_id' => $user->id,
            'balance' => 5000,
        ]);

        Deposit::create([
            'user_id' => $user->id,
            'amount' => 5000,
            'payment_method' => 'usdt_trc20',
            'status' => 'approved',
        ]);

        $this->artisan('fix:wallet --execute --force')
            ->expectsOutputToContain('Skipped users: 1')
            ->assertExitCode(0);

        $this->assertSame(5000.0, (float) $user->wallet()->value('balance'));
        $this->assertDatabaseMissing('wallet_transactions', [
            'user_id' => $user->id,
            'type' => 'admin_debit',
        ]);
    }
}
