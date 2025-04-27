<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

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

        // Check if the email is already registered
        if (User::where('email', $request->email)->exists()) {
            return back()->with('error', 'Email is already registered.');
        }

        $verification_code = Str::random(6);

        $user_data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_token' => $verification_code,
        ];

        Cache::put('user_registration_' . $verification_code, $user_data, now()->addMinutes(30));

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

        $user_data = Cache::get('user_registration_' . $request->verification_code);

        if (!$user_data) {
            return view('verifyEmail')->with('error', 'Invalid or expired verification code.');
        }

        $user = User::create($user_data);
        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        Cache::forget('user_registration_' . $request->verification_code);

        return redirect('/')->with('message', 'Email verified successfully. You can now login.');
    }

    public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Cek apakah user ada berdasarkan email
    $user = User::where('email', $request->email)->first();

    // Jika user tidak ditemukan atau password salah
    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Invalid credentials.');
    }

    // Cek apakah email sudah diverifikasi
    if (!$user->email_verified_at) {
        return back()->with('error', 'Please verify your email first.');
    }

    // Login user
    Auth::login($user);

    // Redirect ke dashboard atau halaman yang diinginkan setelah login
    return redirect()->route('dashboard');
}
    public function logout(Request $request)
    {
        Auth::logout();                                 // logout user
        $request->session()->invalidate();               // invalidate session
        $request->session()->regenerateToken();          // regen CSRF token

        return redirect('/')
            ->with('status', 'You have been logged out.');
    }
}
