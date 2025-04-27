<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // 1. Tampil form input email
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Kirim kode verifikasi ke email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $verificationCode = Str::random(6);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                // simpan kode verifikasi plain
                'token'      => $verificationCode,
                'created_at' => now(),
            ]
        );

        Mail::send(
            'auth.emails.verification-code',
            ['code' => $verificationCode],
            function ($msg) use ($request) {
                $msg->to($request->email)
                    ->subject('Your Password Reset Verification Code');
            }
        );

        return back()
            ->with('status', 'Verification code sent to your email.')
            ->with('email', $request->email);
    }

    // 3. Verifikasi kode, generate token reset-password plain, kirim ke URL
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email'             => 'required|email',
            'verification_code' => 'required',
        ]);

        $reset = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->first();

        if (! $reset || $reset->token !== $request->verification_code) {
            return back()
                ->withErrors(['verification_code' => 'Invalid verification code.'])
                ->withInput()
                ->with('email', $request->email);
        }

        // generate token reset-password plain
        $newToken = Str::random(60);

        DB::table('password_resets')
            ->where('email', $request->email)
            ->update([
                'token'      => $newToken,
                'created_at' => now(),
            ]);

        // kirim link reset dengan plain token
        return redirect()
            ->route('reset-password', ['token' => $newToken]);
    }

    // 4. Tampil form ganti password (hanya password & confirmation)
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // 5. Reset password: cari record by token, dapatkan email, update user
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        // cari berdasarkan token plain
        $reset = DB::table('password_resets')
                   ->where('token', $request->token)
                   ->where('created_at', '>', now()->subMinutes(60)) // opsional: exp 60 menit
                   ->first();

        if (! $reset) {
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }

        $user = User::where('email', $reset->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // update password
        $user->password = Hash::make($request->password);
        $user->save();

        // hapus record reset
        DB::table('password_resets')
          ->where('email', $reset->email)
          ->delete();

        return redirect()
            ->route('login')
            ->with('status', 'Your password has been reset successfully.');
    }
}
