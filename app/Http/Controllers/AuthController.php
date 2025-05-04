<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

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

    // Hapus dari cache
    Cache::forget('user_registration_' . $request->verification_code);

    // Login otomatis dan set remember me
    Auth::login($user, true); // true artinya remember me diaktifkan

    return redirect('/dashboard')->with('message', 'Email verified and logged in successfully.');
}


    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Pastikan remember me dikirim sebagai boolean
    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Generate remember token JIKA remember me dicentang
        if ($remember) {
            $token = Str::random(60);
            $user->forceFill([
                'remember_token' => hash('sha256', $token),
            ])->save();

            // Buat cookie yang bertahan 30 hari
            $cookie = Cookie::make(
                Auth::getRecallerName(),
                $user->id.'|'.$token.'|'.$user->getAuthPassword(),
                60 * 24 * 30, // 30 hari
                null,
                null,
                false, // Https only? Sesuaikan dengan env
                true // HttpOnly
            );

            return redirect()->intended('dashboard')
                   ->withCookie($cookie);
        }

        return redirect()->intended('dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}

public function logout(Request $request)
{
    // Hapus remember_token di database
    if (Auth::check()) {
        $user = Auth::user();
        $user->setRememberToken(null);
        $user->save();
    }

    // Logout user
    Auth::logout();

    // Invalidate session
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Hapus cookie remember_me (recaller)
    $rememberMeCookie = Cookie::forget(Auth::getRecallerName()); // biasanya "remember_web_*"

    // Redirect ke halaman utama
    return redirect('/')
        ->with('status', 'Anda telah logout')
        ->withCookie($rememberMeCookie);
}

}
