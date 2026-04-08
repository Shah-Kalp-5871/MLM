<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // Generate a unique token
        $token = Str::random(64);

        // Store the token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Send the email
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);
        
        $sent = EmailService::sendPasswordResetEmail($user->email, $user->name, $resetUrl);

        if ($sent) {
            return back()->with('status', 'We have emailed your password reset link!');
        } else {
            return back()->withErrors(['email' => 'Failed to send reset link. Please try again later.']);
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetData || !Hash::check($request->token, $resetData->token)) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        // Check if token expired (15 minutes)
        if (Carbon::parse($resetData->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'The reset link has expired.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset!');
    }
}
