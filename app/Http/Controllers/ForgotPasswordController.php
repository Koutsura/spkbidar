<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class ForgotPasswordController extends Controller
{
    protected $expirationMinutes = 60; // Token expiration time in minutes

    // Show the form for forgot password
    public function showForgotPasswordForm()
    {
        // Force user to input email first
        session()->forget(['step', 'email']);
        return view('auth.forgot-password');
    }

    // Send reset password link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        session(['email' => $email, 'step' => 'code']);

        // Rate limiting
        $throttleKey = 'reset-password:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors(['email' => "Please wait {$seconds} seconds before trying again."]);
        }

        RateLimiter::hit($throttleKey);

        // Generate verification code
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store or update the reset token
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $verificationCode,
                'created_at' => now(),
            ]
        );

        try {
            // Send email with verification code
            Mail::send('auth.emails.verification-code', ['code' => $verificationCode], function ($msg) use ($email) {
                $msg->to($email)->subject('Your Password Reset Verification Code');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send verification email. Please try again.']);
        }

        // Redirect to the same page for the verification code
        return redirect()->route('verify-code')->with('status', 'Verification code sent to your email.');
    }

    public function showVerifyCodeForm()
    {
        // Retrieve the email from the session to display on the verification form
        return view('auth.forgot-password')->with('email', session('email'));
    }

    public function resendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        session(['email' => $email, 'step' => 'code']);

        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $verificationCode,
                'created_at' => now(),
            ]
        );

        try {
            Mail::send('auth.emails.verification-code', ['code' => $verificationCode], function ($msg) use ($email) {
                $msg->to($email)->subject('Resend: Your Password Reset Verification Code');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to resend verification email. Please try again.']);
        }

        return back()->with('status', 'Verification code has been resent to your email.');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|size:6'
        ]);

        $reset = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$reset || $reset->token !== $request->verification_code) {
            return back()
                ->withErrors(['verification_code' => 'Invalid verification code.'])
                ->withInput()
                ->with('email', $request->email);
        }

        if (now()->diffInMinutes($reset->created_at) > $this->expirationMinutes) {
            return back()
                ->withErrors(['verification_code' => 'Verification code has expired.'])
                ->withInput()
                ->with('email', $request->email);
        }

        // Generate a new token for resetting the password
        $newToken = Str::random(60);

        DB::table('password_resets')
            ->where('email', $request->email)
            ->update([
                'token' => $newToken,
                'created_at' => now(),
            ]);

        return redirect()->route('reset-password', ['token' => $newToken]);
    }

    public function showResetPasswordForm($token)
    {
        $reset = DB::table('password_resets')
            ->where('token', $token)
            ->where('created_at', '>', now()->subMinutes($this->expirationMinutes))
            ->first();

        if (!$reset) {
            return redirect('/forgot-password')->withErrors(['token' => 'Invalid or expired token. Please request a new verification code.']);
        }

        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:5|confirmed',
        ]);

        $reset = DB::table('password_resets')
            ->where('token', $request->token)
            ->where('created_at', '>', now()->subMinutes($this->expirationMinutes))
            ->first();

        if (!$reset) {
            return back()->withErrors(['token' => 'Invalid or expired token. Please request a new verification code.']);
        }

        $user = User::where('email', $reset->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $reset->email)->delete();

        return redirect('/login')->with('status', 'Your password has been reset successfully. You can now login with your new password.');
    }
}
