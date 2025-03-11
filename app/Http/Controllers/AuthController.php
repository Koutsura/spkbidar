<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $verification_code = Str::random(6);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_token' => $verification_code,
        ]);

        Mail::send([], [], function($message) use ($request, $verification_code) {
            $message->from('dennykun76@gmail.com', config('app.name'));
            $message->to($request->email);
            $message->subject('Email Verification');
            $message->text('Your verification code is: ' . $verification_code);
        });

        return view('verifyEmail')->with('message', 'Please check your email for the verification code.');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string',
        ]);

        $user = User::where('verification_token', $request->verification_code)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Invalid verification code.');
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        return redirect('/')->with('message', 'Email verified successfully. You can now login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials.');
        }

        if (!$user->email_verified_at) {
            return back()->with('error', 'Please verify your email first.');
        }

        // ...existing code...
        // Logic for logging in the user
    }
}
