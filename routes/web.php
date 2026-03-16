<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Auth Routes (Static UI)
Route::group(['prefix' => 'auth'], function () {
    Route::view('/login', 'auth.login');
    Route::view('/register', 'auth.register');
});

// User Panel Routes (Static UI)
Route::group(['prefix' => 'user'], function () {
    Route::view('/dashboard', 'user.dashboard');
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
    Route::view('/dashboard', 'admin.dashboard.index');
    Route::view('/users', 'admin.users.index');
    Route::view('/users/create', 'admin.users.create');
    Route::view('/users/edit', 'admin.users.edit');
    Route::view('/deposits', 'admin.deposits.index');
    Route::view('/withdrawals', 'admin.withdrawals.index');
    Route::view('/roi', 'admin.roi.index');
    Route::view('/level-income', 'admin.level-income.index');
    Route::view('/network', 'admin.network.index');
    Route::view('/club', 'admin.club.index');
    Route::view('/vouchers', 'admin.vouchers.index');
    Route::view('/vouchers/create', 'admin.vouchers.create');
    Route::view('/reports', 'admin.reports.index');
});
