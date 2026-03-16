<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'referral_code' => 'nullable|exists:users,referral_code',
        ]);

        $upline = null;
        if ($request->referral_code) {
            $upline = User::where('referral_code', $request->referral_code)->first();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'referral_code' => 'NEXA' . rand(1000, 9999),
            'upline_id' => $upline ? $upline->id : null,
            'status' => 'active',
        ]);

        // Create Wallet for new user
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0,
            'total_roi_earned' => 0,
            'total_commission_earned' => 0,
            'total_withdrawn' => 0,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
