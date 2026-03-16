$ErrorActionPreference = "Stop"

$baseDir = "C:\laravel-projects\mlm"

# 1. Root Structure
$dirs = @(
    "app", "bootstrap", "config", "database", "public", "resources", "routes", "storage", "tests", "vendor",
    "app\Console\Commands", "app\Http\Controllers\Auth", "app\Http\Controllers\User", "app\Http\Controllers\Admin", 
    "app\Http\Middleware", "app\Http\Requests", "app\Models", "app\Services", "app\Repositories", "app\Helpers", "app\Traits",
    "database\migrations", "database\seeders", "database\factories",
    "resources\views\layouts", "resources\views\auth", "resources\views\user\investments", "resources\views\user\wallet", 
    "resources\views\user\withdrawals", "resources\views\user\referrals", "resources\views\user\network", "resources\views\user\roi", 
    "resources\views\user\level-income", "resources\views\user\club-rewards", "resources\views\user\profile", 
    "resources\views\admin\dashboard", "resources\views\admin\users", "resources\views\admin\deposits", 
    "resources\views\admin\withdrawals", "resources\views\admin\roi", "resources\views\admin\level-income", "resources\views\admin\network", 
    "resources\views\admin\club", "resources\views\admin\vouchers", "resources\views\admin\reports",
    "public\css", "public\js", "public\images", "public\uploads",
    "storage\app", "storage\logs", "storage\framework"
)

foreach ($dir in $dirs) {
    if (-not (Test-Path "$baseDir\$dir")) {
        New-Item -ItemType Directory -Force -Path "$baseDir\$dir" | Out-Null
    }
}

$files = @(
    ".env", "composer.json", "artisan",
    "app\Http\Controllers\Auth\LoginController.php", "app\Http\Controllers\Auth\RegisterController.php",
    "app\Http\Controllers\User\DashboardController.php", "app\Http\Controllers\User\InvestmentController.php", "app\Http\Controllers\User\WalletController.php", "app\Http\Controllers\User\WithdrawalController.php", "app\Http\Controllers\User\ReferralController.php", "app\Http\Controllers\User\NetworkController.php", "app\Http\Controllers\User\ROIController.php", "app\Http\Controllers\User\LevelIncomeController.php", "app\Http\Controllers\User\ClubRewardController.php", "app\Http\Controllers\User\ProfileController.php",
    "app\Http\Controllers\Admin\DashboardController.php", "app\Http\Controllers\Admin\UserController.php", "app\Http\Controllers\Admin\DepositController.php", "app\Http\Controllers\Admin\WithdrawalController.php", "app\Http\Controllers\Admin\ROIController.php", "app\Http\Controllers\Admin\LevelCommissionController.php", "app\Http\Controllers\Admin\NetworkController.php", "app\Http\Controllers\Admin\ClubController.php", "app\Http\Controllers\Admin\VoucherController.php", "app\Http\Controllers\Admin\ReportController.php",
    "app\Models\User.php", "app\Models\Investment.php", "app\Models\Wallet.php", "app\Models\WalletTransaction.php", "app\Models\Withdrawal.php", "app\Models\Deposit.php", "app\Models\Referral.php", "app\Models\LevelCommission.php", "app\Models\ROIIncome.php", "app\Models\ClubReward.php", "app\Models\Voucher.php", "app\Models\VoucherRedemption.php",
    "app\Services\ROIService.php", "app\Services\LevelIncomeService.php", "app\Services\ReferralService.php", "app\Services\TeamBusinessService.php", "app\Services\DirectBusinessService.php", "app\Services\ClubQualificationService.php", "app\Services\VoucherService.php", "app\Services\WalletService.php",
    "app\Repositories\UserRepository.php", "app\Repositories\InvestmentRepository.php", "app\Repositories\WalletRepository.php", "app\Repositories\ReferralRepository.php", "app\Repositories\TransactionRepository.php",
    "app\Console\Commands\DistributeROI.php", "app\Console\Commands\DistributeLevelCommission.php", "app\Console\Commands\CheckClubQualification.php", "app\Console\Kernel.php",
    "routes\web.php", "routes\api.php", "routes\admin.php", "routes\user.php",
    "database\migrations\create_users_table.php", "database\migrations\create_investments_table.php", "database\migrations\create_wallets_table.php", "database\migrations\create_wallet_transactions_table.php", "database\migrations\create_withdrawals_table.php", "database\migrations\create_vouchers_table.php", "database\migrations\create_level_commissions_table.php", "database\migrations\create_roi_incomes_table.php", "database\migrations\create_club_rewards_table.php",
    "resources\views\auth\login.blade.php", "resources\views\auth\register.blade.php", "resources\views\user\dashboard.blade.php",
    "config\mlm.php", "config\wallet.php", "config\roi.php", "config\levels.php"
)

foreach ($file in $files) {
    if (-not (Test-Path "$baseDir\$file")) {
        New-Item -ItemType File -Force -Path "$baseDir\$file" | Out-Null
    }
}

$levelsConfig = @"
<?php

return [
    1 => 20,
    2 => 12,
    3 => 9,
    4 => 6,
    5 => 6,
    6 => 6,
    7 => 4,
    8 => 4,
    9 => 4,
    10 => 4,
    11 => 2,
    12 => 2,
    13 => 2,
    14 => 2,
    15 => 2
];
"@

Set-Content -Path "$baseDir\config\levels.php" -Value $levelsConfig

Write-Output "Structure created successfully."
