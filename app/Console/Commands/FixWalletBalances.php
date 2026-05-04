<?php

namespace App\Console\Commands;

use App\Models\Deposit;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixWalletBalances extends Command
{
    protected $signature = 'fix:wallet
        {--dry-run : Show affected users without changing data}
        {--execute : Apply safe wallet corrections}
        {--force : Required with --execute after manual review}';

    protected $description = 'Detect and safely correct wallet balances inflated by investment approval credits';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $execute = (bool) $this->option('execute');
        $force = (bool) $this->option('force');

        if ($dryRun === $execute) {
            $this->error('Choose exactly one mode: --dry-run or --execute.');
            return self::FAILURE;
        }

        if ($execute && ! $force) {
            $this->error('Execution is blocked until reviewed. Re-run with --execute --force.');
            return self::FAILURE;
        }

        $summary = [
            'checked' => 0,
            'affected' => 0,
            'corrected' => 0,
            'skipped' => 0,
            'total_corrected' => 0.0,
        ];

        $rows = [];

        Wallet::with('user')
            ->where('balance', '>', 0)
            ->chunkById(100, function ($wallets) use ($dryRun, $execute, &$summary, &$rows): void {
                foreach ($wallets as $wallet) {
                    $summary['checked']++;

                    $review = $this->reviewWallet($wallet);

                    if (! $review['is_suspicious']) {
                        continue;
                    }

                    $summary['affected']++;

                    if ($review['can_correct']) {
                        $rows[] = [
                            $wallet->user_id,
                            $wallet->user?->email ?? '-',
                            $this->money($review['wallet_balance']),
                            $this->money($review['approved_investment']),
                            $this->money($review['bugged_amount']),
                            $execute ? 'corrected' : 'traceable',
                        ];

                        if ($execute) {
                            $deducted = $this->correctWallet($wallet->user_id, $review['bugged_amount']);
                            $summary['corrected']++;
                            $summary['total_corrected'] += $deducted;
                        }

                        continue;
                    }

                    $summary['skipped']++;
                    $rows[] = [
                        $wallet->user_id,
                        $wallet->user?->email ?? '-',
                        $this->money($review['wallet_balance']),
                        $this->money($review['approved_investment']),
                        $this->money($review['bugged_amount']),
                        'skipped: ' . $review['reason'],
                    ];
                }
            });

        if ($rows) {
            $this->table(
                ['User ID', 'Email', 'Wallet', 'Approved Investment', 'Traceable Bug Credit', 'Status'],
                $rows
            );
        } else {
            $this->info('No suspicious wallet balances found.');
        }

        $this->newLine();
        $this->info('Total users checked: ' . $summary['checked']);
        $this->info('Affected users: ' . $summary['affected']);
        $this->info('Corrected users: ' . $summary['corrected']);
        $this->info('Skipped users: ' . $summary['skipped']);
        $this->info('Total corrected amount: ' . $this->money($summary['total_corrected']));

        if ($dryRun) {
            $this->warn('Dry run only. No database changes were made.');
        }

        return self::SUCCESS;
    }

    private function reviewWallet(Wallet $wallet): array
    {
        $walletBalance = (float) $wallet->balance;
        $approvedInvestment = (float) Deposit::where('user_id', $wallet->user_id)
            ->where('status', 'approved')
            ->sum('amount');

        if ($walletBalance <= 0 || $approvedInvestment <= 0) {
            return [
                'is_suspicious' => false,
                'can_correct' => false,
                'wallet_balance' => $walletBalance,
                'approved_investment' => $approvedInvestment,
                'bugged_amount' => 0.0,
                'reason' => 'no positive wallet and approved investment pair',
            ];
        }

        $buggedAmount = (float) WalletTransaction::where('user_id', $wallet->user_id)
            ->where('wallet', 'cash')
            ->where('direction', 'credit')
            ->whereIn('type', ['deposit', 'investment_credit'])
            ->sum('amount');

        if ($buggedAmount <= 0) {
            return [
                'is_suspicious' => true,
                'can_correct' => false,
                'wallet_balance' => $walletBalance,
                'approved_investment' => $approvedInvestment,
                'bugged_amount' => 0.0,
                'reason' => 'no traceable bug transaction history',
            ];
        }

        if ($buggedAmount > $walletBalance) {
            return [
                'is_suspicious' => true,
                'can_correct' => false,
                'wallet_balance' => $walletBalance,
                'approved_investment' => $approvedInvestment,
                'bugged_amount' => $buggedAmount,
                'reason' => 'bug credit exceeds current wallet balance',
            ];
        }

        return [
            'is_suspicious' => true,
            'can_correct' => true,
            'wallet_balance' => $walletBalance,
            'approved_investment' => $approvedInvestment,
            'bugged_amount' => $buggedAmount,
            'reason' => 'traceable bug transactions found',
        ];
    }

    private function correctWallet(int $userId, float $buggedAmount): float
    {
        return DB::transaction(function () use ($userId, $buggedAmount): float {
            $wallet = Wallet::where('user_id', $userId)->lockForUpdate()->firstOrFail();
            $oldWallet = (float) $wallet->balance;

            if ($buggedAmount <= 0 || $buggedAmount > $oldWallet) {
                throw new \RuntimeException("Unsafe correction skipped for user {$userId}.");
            }

            $newWallet = round($oldWallet - $buggedAmount, 2);

            $wallet->update(['balance' => $newWallet]);

            WalletTransaction::create([
                'user_id' => $userId,
                'type' => 'admin_debit',
                'wallet' => 'cash',
                'amount' => $buggedAmount,
                'direction' => 'debit',
                'balance_after' => $newWallet,
                'reference_type' => self::class,
                'description' => 'Wallet correction: removed traceable investment approval principal credit',
            ]);

            $this->writeFixLog([
                'user_id' => $userId,
                'old_wallet' => $this->money($oldWallet),
                'bugged_amount' => $this->money($buggedAmount),
                'deducted_amount' => $this->money($buggedAmount),
                'new_wallet' => $this->money($newWallet),
                'fixed_at' => now()->toDateTimeString(),
            ]);

            return $buggedAmount;
        });
    }

    private function writeFixLog(array $data): void
    {
        $line = json_encode($data, JSON_UNESCAPED_SLASHES) . PHP_EOL;

        file_put_contents(storage_path('logs/wallet_fix.log'), $line, FILE_APPEND | LOCK_EX);
    }

    private function money(float $amount): string
    {
        return number_format($amount, 2, '.', '');
    }
}
