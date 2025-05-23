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
use Illuminate\Support\Facades\Log;


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
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8',
    ]);

    $email = $request->email;

    // 1. Cek jika email sudah terdaftar di database
    if (User::where('email', $email)->exists()) {
        return back()->with('error', 'Email sudah terdaftar. Silakan login.');
    }

    // 2. Jika data pendaftaran sudah ada di cache (belum diverifikasi), arahkan langsung ke halaman OTP
    if (Cache::has('user_registration_' . $email)) {
        Session::put('pending_email', $email);
        return redirect()->route('verify.email.form')
               ->with('message', 'Kode verifikasi sudah dikirim. Silakan cek email Anda.');
    }

    // 3. Email belum digunakan sama sekali → buat OTP dan simpan di cache
    $verification_code = strtoupper(Str::random(6));

    $user_data = [
        'name' => strip_tags($request->name),
        'email' => $email,
        'password' => Hash::make($request->password),
        'verification_token' => $verification_code,
        'role' => 'mahasiswa',
    ];

    Cache::put('user_registration_' . $email, $user_data, now()->addMinutes(30));
    Session::put('pending_email', $email);

    // 4. Kirim email
    try {
        Mail::send([], [], function ($message) use ($email, $verification_code) {
            $message->from('dennykun76@gmail.com', config('app.name'));
            $message->to($email);
            $message->subject('Email Verification');
            $message->text('Kode verifikasi Anda adalah: ' . $verification_code);
        });
    } catch (\Exception $e) {
        Cache::forget('user_registration_' . $email);
        Session::forget('pending_email');
        return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
    }

    return redirect()->route('verify.email.form')
           ->with('message', 'Kode verifikasi telah dikirim ke email Anda.');
}




    public function verifyEmail(Request $request)
{
    $request->validate([
        'code' => 'required|array|size:6',
    ]);

    // Gabungkan array code menjadi string
    $verificationCode = implode('', $request->code);

    // Ambil email dari session
    $email = Session::get('pending_email');

    if (!$email) {
        return redirect('/register')->with('error', 'Session expired. Please register again.');
    }

    // Ambil data dari cache menggunakan EMAIL sebagai key
    $user_data = Cache::get('user_registration_' . $email);

    if (!$user_data || $user_data['verification_token'] !== $verificationCode) {
        return view('verifyEmail')->with('error', 'Invalid or expired verification code.');
    }

    $user = User::create($user_data);
    $user->email_verified_at = now();
    $user->verification_token = null;
    $user->save();

    Cache::forget('user_registration_' . $email);
    Session::forget('pending_email');

    Auth::login($user, true);

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

public function resendCode(Request $request)
{
    $email = $request->input('pending_email');

    if (!$email) {
        return response()->json(['error' => 'Email not found. Please register again.'], 400);
    }

    $cachedUser = Cache::get('user_registration_' . $email);

    if (!$cachedUser) {
        return response()->json(['error' => 'Verification data not found. Please register again.'], 400);
    }

    $newCode = Str::random(6);
    $cachedUser['verification_token'] = $newCode;
    Cache::put('user_registration_' . $email, $cachedUser, now()->addMinutes(30));

    try {
        Mail::send([], [], function ($message) use ($email, $newCode) {
            $message->from('dennykun76@gmail.com', config('app.name'));
            $message->to($email);
            $message->subject('Resend Verification Code');
            $message->text('Your new verification code is: ' . $newCode);
        });

        Session::put('pending_email', $email);
        \Log::info('Resent verification code:', ['email' => $email]);

        return response()->json(['message' => 'A new verification code has been sent to your email.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to send email. Please try again.'], 500);
    }
}





}
