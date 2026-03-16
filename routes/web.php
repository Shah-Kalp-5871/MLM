<?php
use Illuminate\Support\Facades\Route;

Route::get('/test/verify', [\App\Http\Controllers\TestController::class, 'verify']);

Route::view('/', 'welcome');

// Auth Routes (Static UI)
Route::group(['prefix' => 'auth'], function () {
    Route::view('/login', 'auth.login');
    Route::view('/register', 'auth.register');
});

// User Panel Routes (Static UI)
Route::group(['prefix' => 'user'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index']);
    Route::view('/investments', 'user.investments.index');
    Route::view('/investments/create', 'user.investments.create');
    Route::view('/wallet', 'user.wallet.index');
    Route::view('/withdrawals', 'user.withdrawals.index');
    Route::view('/withdrawals/create', 'user.withdrawals.create');
    Route::view('/referrals', 'user.referrals.index');
    Route::view('/network', 'user.network.index');
    Route::view('/earnings', 'user.earnings');
    Route::view('/club-rewards', 'user.club-rewards.index');
    Route::view('/profile', 'user.profile.index');
});

// Admin Panel Routes (Static UI)
Route::group(['prefix' => 'admin'], function () {
    Route::view('/login', 'admin.auth.login');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::view('/users', 'admin.users.index');
    Route::view('/users/create', 'admin.users.create');
    Route::view('/users/edit', 'admin.users.edit');
    Route::get('/deposits', [\App\Http\Controllers\Admin\DepositController::class, 'index']);
    Route::post('/deposits/{id}/approve', [\App\Http\Controllers\Admin\DepositController::class, 'approve']);
    Route::post('/deposits/{id}/reject', [\App\Http\Controllers\Admin\DepositController::class, 'reject']);
    Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index']);
    Route::post('/withdrawals/{id}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve']);
    Route::post('/withdrawals/{id}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject']);
    Route::get('/roi', [\App\Http\Controllers\Admin\IncomeController::class, 'roiIndex']);
    Route::post('/roi/run', [\App\Http\Controllers\Admin\IncomeController::class, 'runROI']);
    Route::get('/level-income', [\App\Http\Controllers\Admin\IncomeController::class, 'levelIndex']);
    Route::view('/network', 'admin.network.index');
    Route::view('/club', 'admin.club.index');
    Route::view('/vouchers', 'admin.vouchers.index');
    Route::view('/vouchers/create', 'admin.vouchers.create');
    Route::view('/packages', 'admin.packages.index');
    Route::view('/level-settings', 'admin.level-settings.index');
    Route::view('/club-milestones', 'admin.club-milestones.index');
    Route::view('/reports', 'admin.reports.index');
    Route::view('/activity-logs', 'admin.activity-logs.index');
});
