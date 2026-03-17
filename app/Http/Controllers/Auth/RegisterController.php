<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    // ─── Step 1: Show signup form ───────────────────────────────────────────────
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // ─── Step 2: Validate form → generate & send OTP → redirect to OTP screen ──
    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'phone'         => 'required|string|max:20',
            'password'      => 'required|string|min:8|confirmed',
            'referral_code' => 'nullable|exists:users,referral_code',
        ]);

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Store pending registration data in session (expires with session)
        session([
            'pending_registration' => [
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'password'      => Hash::make($request->password),
                'referral_code' => $request->referral_code,
                'otp'           => $otp,
                'otp_expires'   => now()->addMinutes(10)->timestamp,
            ],
        ]);

        // Send OTP email
        try {
            EmailService::sendOtpEmail($request->email, $request->name, $otp);
        } catch (\Exception $e) {
            Log::error('OTP email failed: ' . $e->getMessage());
        }

        return redirect()->route('register.otp');
    }

    // ─── Step 3: Show OTP verification screen ───────────────────────────────────
    public function showOtpForm()
    {
        if (!session('pending_registration')) {
            return redirect()->route('register')->withErrors(['email' => 'Session expired. Please register again.']);
        }
        return view('auth.otp');
    }

    // ─── Step 4: Verify OTP → create user ───────────────────────────────────────
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $pending = session('pending_registration');

        if (!$pending) {
            return redirect()->route('register')->withErrors(['email' => 'Session expired. Please register again.']);
        }

        // Check expiry
        if (now()->timestamp > $pending['otp_expires']) {
            session()->forget('pending_registration');
            return redirect()->route('register')->withErrors(['email' => 'OTP expired. Please register again.']);
        }

        // Check OTP match
        if ((string)$request->otp !== (string)$pending['otp']) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        // Create user
        $upline = null;
        if ($pending['referral_code']) {
            $upline = User::where('referral_code', $pending['referral_code'])->first();
        }

        $user = User::create([
            'name'          => $pending['name'],
            'email'         => $pending['email'],
            'phone'         => $pending['phone'],
            'password'      => $pending['password'],

            'referral_code' => $this->generateUniqueReferralCode(),
            'upline_id'     => $upline ? $upline->id : null,
            'status'        => 'active',
        ]);

        Wallet::create([
            'user_id'                  => $user->id,
            'balance'                  => 0,
            'total_roi_earned'         => 0,
            'total_commission_earned'  => 0,
            'total_withdrawn'          => 0,
        ]);

        // Send welcome email
        try {
            EmailService::sendWelcomeEmail($user->email, $user->name);
        } catch (\Exception $e) {
            Log::error('Welcome email failed: ' . $e->getMessage());
        }

        // Clear session
        session()->forget('pending_registration');

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // ─── Resend OTP ──────────────────────────────────────────────────────────────
    public function resendOtp()
    {
        $pending = session('pending_registration');

        if (!$pending) {
            return redirect()->route('register')->withErrors(['email' => 'Session expired. Please register again.']);
        }

        $newOtp = rand(100000, 999999);
        $pending['otp'] = $newOtp;
        $pending['otp_expires'] = now()->addMinutes(10)->timestamp;
        session(['pending_registration' => $pending]);

        try {
            EmailService::sendOtpEmail($pending['email'], $pending['name'], $newOtp);
        } catch (\Exception $e) {
            Log::error('Resend OTP failed: ' . $e->getMessage());
        }

        return back()->with('resent', 'A new OTP has been sent to your email.');
    }

    // ─── Generate Unique Referral Code ─────────────────────────────────────────
    private function generateUniqueReferralCode(): string
    {
        do {
            // Generate a 5-digit code for 90,000 possible combinations per prefix
            $code = 'NEXA' . rand(10000, 99999);
            
            // Query the database to see if this code already exists
            $exists = User::where('referral_code', $code)->exists();
            
        } while ($exists);

        return $code;
    }
}
