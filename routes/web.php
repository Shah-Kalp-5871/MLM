<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\InvestmentController as UserInvestmentController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\WithdrawalController;
use App\Http\Controllers\User\ReferralController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\LevelIncomeController;
use App\Http\Controllers\User\ROIController;
use App\Http\Controllers\User\EarningsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DepositController as AdminDepositController;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;
use App\Http\Controllers\Admin\InvestmentController as AdminInvestmentController;
use App\Http\Controllers\Admin\ROIController as AdminROIController;
use App\Http\Controllers\Admin\LevelCommissionController as AdminCommissionController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\NetworkController as AdminNetworkController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/test/verify', [\App\Http\Controllers\TestController::class, 'verify']);

Route::get('/test-mail', function () {
    return app(\App\Services\EmailService::class)
        ->sendWelcomeEmail('test@example.com', 'Test User') 
        ? 'Email Sent successfully!' 
        : 'Email Sending Failed! Check logs.';
});

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Investments
    Route::get('/investments', [UserInvestmentController::class, 'index'])->name('investments.index');
    Route::get('/invest', [UserInvestmentController::class, 'create'])->name('invest.create');
    Route::post('/invest', [UserInvestmentController::class, 'store'])->name('invest.store');
    
    Route::get('/deposits', [DepositController::class, 'index'])->name('deposits.index');
    Route::post('/deposits', [DepositController::class, 'store'])->name('deposits.store');
    
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    
    Route::get('/withdraw', [WithdrawalController::class, 'create'])->name('withdraw.create');
    Route::post('/withdraw', [WithdrawalController::class, 'store'])->name('withdraw.store');
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::get('/withdrawals/{id}/receipt', [WithdrawalController::class, 'receipt'])->name('withdrawals.receipt');
    
    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/team', [ReferralController::class, 'team'])->name('network.index');
    Route::get('/level-income', [LevelIncomeController::class, 'index'])->name('level-income.index');
    Route::get('/roi', [ROIController::class, 'index'])->name('roi.index');
    Route::get('/earnings', [EarningsController::class, 'index'])->name('earnings.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Club & Vouchers
    Route::get('/club', [App\Http\Controllers\User\ClubController::class, 'index'])->name('club.index');
    Route::get('/vouchers', [App\Http\Controllers\User\VoucherController::class, 'index'])->name('vouchers.index');
    Route::get('/vouchers/redeem', [App\Http\Controllers\User\VoucherController::class, 'showRedeemForm'])->name('vouchers.redeem');
    Route::post('/vouchers/redeem', [App\Http\Controllers\User\VoucherController::class, 'redeem'])->name('vouchers.redeem.submit');
});

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Authentication Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', [\App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [\App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');
});

// Admin Routes (Protected)
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin']], function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
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
    
    Route::get('/roi', [\App\Http\Controllers\Admin\IncomeController::class, 'roiIndex'])->name('roi.index');
    Route::post('/roi/trigger', [\App\Http\Controllers\Admin\IncomeController::class, 'triggerROI'])->name('roi.trigger');

    
    Route::get('/commissions', [\App\Http\Controllers\Admin\IncomeController::class, 'levelIndex'])->name('commissions.index');
    
    Route::get('/level-settings', [\App\Http\Controllers\Admin\LevelSettingController::class, 'index'])->name('level-settings.index');
    Route::post('/level-settings', [\App\Http\Controllers\Admin\LevelSettingController::class, 'update'])->name('level-settings.update');
    
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/trigger', [\App\Http\Controllers\Admin\ReportController::class, 'triggerDaily'])->name('reports.trigger');
    Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('reports.export');
    Route::get('/reports/vouchers', [\App\Http\Controllers\Admin\ReportController::class, 'voucherReport'])->name('reports.vouchers');
    Route::get('/settings', [AdminSettingsController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::get('/network', [AdminNetworkController::class, 'index'])->name('network.index');

    // Payment Methods CRUD
    Route::get('/payment-methods', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'index'])->name('payment-methods.index');
    Route::post('/payment-methods', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'store'])->name('payment-methods.store');
    Route::put('/payment-methods/{id}', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'update'])->name('payment-methods.update');
    Route::delete('/payment-methods/{id}', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'destroy'])->name('payment-methods.destroy');
});

// Auth Routes
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/register/otp', [RegisterController::class, 'showOtpForm'])->name('register.otp');
    Route::post('/register/otp', [RegisterController::class, 'verifyOtp'])->name('register.otp.verify');
    Route::get('/register/otp/resend', [RegisterController::class, 'resendOtp'])->name('register.otp.resend');
});
