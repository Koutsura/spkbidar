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
use App\Models\Pendaftaran;
use App\Models\Setting;


class AuthController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $role = $user->role;

    $count_pending = Pendaftaran::where('user_id', $user->id)->where('status', 'pending')->count();
    $count_diterima = Pendaftaran::where('user_id', $user->id)->where('status', 'diterima')->count();
    $count_ditolak  = Pendaftaran::where('user_id', $user->id)->where('status', 'ditolak')->count();

    if ($role === 'superadmin') {
        $count_pending = Pendaftaran::where('status', 'pending')->count();
        $count_diterima = Pendaftaran::where('status', 'diterima')->count();
        $count_ditolak  = Pendaftaran::where('status', 'ditolak')->count();
    }

    // Daftar role UKM dan nama UKM lengkap
    $ukmMapping = [
        'BDCA' => 'UKM Bina Darma Cyber Army (BDCA)',
        'alqarib' => 'UKM LDK ALQORIB',
        'PMKK' => 'UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK)',
        'KMHDI' => 'UKM Kesatuan Mahasiswa Hindu Dharma Indonesia (KMHDI)',
        'MABIDAR' => 'UKM Mahasiswa Pencinta Alam (MABIDAR)',
        'BGK' => 'UKM Bujang Gadis Kampus (BGK)',
        'BDSC' => 'UKM Panduan Suara Mahasiswa (BDSC)',
        'BDCU' => 'UKM Binadarma Debat Union (BDCU)',
        'BDPRO' => 'UKM Bina Darma Programmer (BDPRO)',
        'Olahraga' => 'UKM Olahraga',
        'Pramuka' => 'UKM Pramuka',
        'BRadio' => 'UKM Bina Darma Radio (B-Radio)',
        'SSEC' => 'UKM EDS South Sumatera English Community (SSEC)',
    ];

    $jumlahDiterimaUKM = null;
    $namaUKM = null;
    $pendaftarans = collect();

    if (array_key_exists($role, $ukmMapping)) {
        $namaUKM = $ukmMapping[$role];
        $acceptedUserIds = Pendaftaran::where('status', 'diterima')->pluck('user_id');

        $query = Setting::whereIn('user_id', $acceptedUserIds)
    ->where(function ($q) use ($namaUKM) {
        $q->where('organization_1', $namaUKM)
            ->orWhere('organization_2', $namaUKM)
            ->orWhere('organization_3', $namaUKM);
    })
    ->with('user');

// Hitung jumlah total mahasiswa diterima di UKM ini (tanpa search)
$jumlahDiterimaUKM = $query->count();

// Filter pencarian nama mahasiswa
$search = $request->get('search');
if ($search) {
    $query->whereHas('user', function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%');
    });
}

// Ambil data mahasiswa diterima (pakai filter search jika ada)
$pendaftarans = $query->get();
    }

    return view('dashboard', compact(
        'count_pending',
        'count_diterima',
        'count_ditolak',
        'jumlahDiterimaUKM',
        'pendaftarans',
        'namaUKM'
    ));
}


    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function showVerifyEmailForm()
{
    return view('verifyEmail');
}


   public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|email',
        'password' => 'required|string|min:5',
    ]);

    $email = $request->email;

    // 1. Cek jika email sudah terdaftar di database (sudah verifikasi)
    if (User::where('email', $email)->exists()) {
        return back()->with('error', 'Email sudah terdaftar. Silakan login.');
    }

    // 2. Cek apakah email sudah ada di cache (belum verifikasi)
    if (Cache::has('user_registration_' . $email)) {
        // Ambil data yang tersimpan
        $cachedUser = Cache::get('user_registration_' . $email);

        // Generate kode baru dan perbarui
        $newCode = strtoupper(Str::random(6));
        $cachedUser['verification_token'] = $newCode;

        // Simpan kembali ke cache (reset waktu simpan)
        Cache::put('user_registration_' . $email, $cachedUser, now()->addMinutes(30));

        // Kirim ulang email OTP
        try {
            Mail::send([], [], function ($message) use ($email, $newCode) {
                $message->from('dennykun76@gmail.com', config('app.name'));
                $message->to($email);
                $message->subject('Kode Verifikasi Baru');
                $message->text('Kode verifikasi baru Anda adalah: ' . $newCode);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim ulang kode. Silakan coba lagi.');
        }

        Session::put('pending_email', $email);

        return redirect()->route('verification.form')->with('message', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }

    // 3. Jika email belum pernah didaftarkan sama sekali
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

    // Kirim email OTP baru
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

    return redirect()->route('verification.form')->with('message', 'Kode verifikasi telah dikirim ke email Anda.');
}





    public function verifyEmail(Request $request)
{
    $request->validate([
        'code' => 'required|array|size:6',
    ]);

    $verificationCode = implode('', $request->code);

    $email = Session::get('pending_email');

    if (!$email) {
        return redirect('/register')->with('error', 'Session expired. Silakan daftar ulang.');
    }

    $user_data = Cache::get('user_registration_' . $email);

    if (!$user_data || $user_data['verification_token'] !== $verificationCode) {
        return view('verifyEmail')->with('error', 'Kode verifikasi salah atau sudah kadaluarsa.');
    }

    $user = User::create($user_data);
    $user->email_verified_at = now();
    $user->verification_token = null;
    $user->save();

    Cache::forget('user_registration_' . $email);
    Session::forget('pending_email');

    Auth::login($user, true);

    return redirect('/dashboard')->with('message', 'Email berhasil diverifikasi dan Anda sudah login.');
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

    return back()->withErrors(['email' => 'Password atau email salah']);
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
