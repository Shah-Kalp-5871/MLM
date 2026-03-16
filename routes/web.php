<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PackageController;
use App\Http\Controllers\User\InvestmentController as UserInvestmentController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\WithdrawalController;
use App\Http\Controllers\User\ReferralController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\LevelIncomeController;
use App\Http\Controllers\User\ROIController;
use App\Http\Controllers\User\ClubRewardController;
use App\Http\Controllers\User\EarningsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DepositController as AdminDepositController;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;
use App\Http\Controllers\Admin\InvestmentController as AdminInvestmentController;
use App\Http\Controllers\Admin\ROIController as AdminROIController;
use App\Http\Controllers\Admin\LevelCommissionController as AdminCommissionController;
use App\Http\Controllers\Admin\ClubRewardController as AdminClubController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/verify', [\App\Http\Controllers\TestController::class, 'verify']);

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    // Investments
    Route::get('/investments', [UserInvestmentController::class, 'index'])->name('investments.index');
    Route::get('/invest', [UserInvestmentController::class, 'create'])->name('invest.create');
    Route::post('/invest', [UserInvestmentController::class, 'store'])->name('invest.store');
    
    Route::get('/deposits', [DepositController::class, 'index'])->name('deposits.index');
    Route::post('/deposits', [DepositController::class, 'store'])->name('deposits.store');
    
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    
    Route::get('/withdraw', [WithdrawalController::class, 'create'])->name('withdraw.create');
    Route::post('/withdraw', [WithdrawalController::class, 'store'])->name('withdraw.store');
    
    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/team', [ReferralController::class, 'team'])->name('team.index');
    Route::get('/level-income', [LevelIncomeController::class, 'index'])->name('level-income.index');
    Route::get('/roi', [ROIController::class, 'index'])->name('roi.index');
    Route::get('/club-rewards', [ClubRewardController::class, 'index'])->name('club-rewards.index');
    Route::get('/earnings', [EarningsController::class, 'index'])->name('earnings.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);
    Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class);
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/status', [AdminUserController::class, 'updateStatus'])->name('users.update-status');
    Route::get('/deposits', [AdminDepositController::class, 'index'])->name('deposits.index');
    Route::post('/deposits/{id}/approve', [AdminDepositController::class, 'approve'])->name('deposits.approve');
    Route::post('/deposits/{id}/reject', [AdminDepositController::class, 'reject'])->name('deposits.reject');
    
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals/{id}/approve', [AdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{id}/reject', [AdminWithdrawalController::class, 'reject'])->name('withdrawals.reject');
    
    Route::get('/investments', [AdminInvestmentController::class, 'index'])->name('investments.index');
    
    Route::get('/roi', [AdminROIController::class, 'index'])->name('roi.index');
    Route::post('/roi/run', [AdminROIController::class, 'run'])->name('roi.run');
    
    Route::get('/commissions', [AdminCommissionController::class, 'index'])->name('commissions.index');
    Route::get('/clubs', [AdminClubController::class, 'index'])->name('clubs.index');
    Route::get('/level-settings', [\App\Http\Controllers\Admin\LevelSettingController::class, 'index'])->name('level-settings.index');
    Route::post('/level-settings', [\App\Http\Controllers\Admin\LevelSettingController::class, 'update'])->name('level-settings.update');
    Route::get('/club-milestones', [\App\Http\Controllers\Admin\ClubMilestoneController::class, 'index'])->name('club-milestones.index');
    Route::post('/club-milestones', [\App\Http\Controllers\Admin\ClubMilestoneController::class, 'store'])->name('club-milestones.store');
    Route::put('/club-milestones/{id}', [\App\Http\Controllers\Admin\ClubMilestoneController::class, 'update'])->name('club-milestones.update');
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/settings', [AdminSettingsController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
});

// Auth Routes (Temporary - should be handled by Laravel Fortify/Breeze)
Route::group(['prefix' => 'auth'], function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});
