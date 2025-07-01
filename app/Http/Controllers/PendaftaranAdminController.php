<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Setting;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranAdminController extends Controller
{
    public function index()
{
    $allowedRoles = [
        'alqarib', 'BDCA', 'BDCU', 'BDPRO', 'BDSC', 'BGK',
        'BRadio', 'KMHDI', 'MABIDAR', 'Olahraga', 'PMKK',
        'Pramuka', 'SSEC'
    ];

    $user = Auth::user();
    $userRole = $user->role;

    if (!in_array($userRole, $allowedRoles)) {
        abort(403, 'Unauthorized');
    }

    // Map role ke nama UKM lengkap
    $ukmMap = [
        'alqarib' => 'UKM LDK ALQORIB',
        'BDCA' => 'UKM Bina Darma Cyber Army (BDCA)',
        'BDCU' => 'UKM Binadarma Debat Union (BDCU)',
        'BDPRO' => 'UKM Bina Darma Programmer (BDPRO)',
        'BDSC' => 'UKM Panduan Suara Mahasiswa (BDSC)',
        'BGK' => 'UKM Bujang Gadis Kampus (BGK)',
        'BRadio' => 'UKM Bina Darma Radio (B-Radio)',
        'KMHDI' => 'UKM Kesatuan Mahasiswa Hindu Darma Indonesia (KMHDI)',
        'MABIDAR' => 'UKM Mahasiswa Pencinta Alam (MABIDAR)',
        'Olahraga' => 'UKM Olahraga',
        'PMKK' => 'UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK)',
        'Pramuka' => 'UKM Pramuka',
        'SSEC' => 'UKM EDS South Sumatera English Community (SSEC)',
    ];

    $ukmName = $ukmMap[$userRole] ?? null;

    if (!$ukmName) {
        abort(403, 'UKM tidak dikenali');
    }

    // Ambil mahasiswa yang status pending
    $pendaftarans = Pendaftaran::with(['user', 'setting'])
        ->where('status', 'pending')
        ->where(function ($query) use ($ukmName) {
            $query->where(function ($q) use ($ukmName) {
                $q->where('organization_1', $ukmName);
            })->orWhere(function ($q) use ($ukmName) {
                $q->where('organization_2', $ukmName);
            })->orWhere(function ($q) use ($ukmName) {
                $q->where('organization_3', $ukmName);
            });
        })
        ->get()
        ->filter(function ($pendaftaran) use ($ukmName) {
            $setting = $pendaftaran->setting;

            // Hanya tampilkan jika mahasiswa belum diterima di posisi yang dimaksud
            return (
                ($pendaftaran->organization_1 === $ukmName && $setting->organization_1 !== $ukmName) ||
                ($pendaftaran->organization_2 === $ukmName && $setting->organization_2 !== $ukmName) ||
                ($pendaftaran->organization_3 === $ukmName && $setting->organization_3 !== $ukmName)
            );
        });

    return view('layouts.admin.pendaftaran.index', compact('pendaftarans'));
}


public function updateStatus($id, $status)
{
    if (!in_array($status, ['diterima', 'ditolak'])) {
        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    $pendaftaran = Pendaftaran::findOrFail($id);
    $pendaftaran->status = $status;
    $pendaftaran->save();

    // Update setting berdasarkan status
    $setting = Setting::where('user_id', $pendaftaran->user_id)->first();

    if ($setting) {
        if ($status === 'diterima') {
            // Update organisasi sesuai pendaftaran yang diterima
            $setting->organization_1 = $pendaftaran->organization_1;
            $setting->organization_2 = $pendaftaran->organization_2;
            $setting->organization_3 = $pendaftaran->organization_3;
            $setting->save();
        }
        // Jika ditolak, jangan ubah organization di setting agar tetap seperti sebelumnya
    }

    // Kirim notifikasi ke user
    Notification::create([
        'user_id' => $pendaftaran->user_id,
        'type' => 'status_pendaftaran',
        'message' => "Pendaftaran UKM Anda telah $status oleh admin.",
        'is_read' => false,
    ]);

    return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui dan notifikasi dikirim.');
}

}
