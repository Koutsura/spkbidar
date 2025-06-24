<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Setting;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranAdminController extends Controller
{
    /**
     * Tampilkan daftar pendaftaran dengan status pending.
     */
    public function index()
    {
        $allowedRoles = [
            'alqarib', 'BDCA', 'BDCU', 'BDPRO', 'BDSC', 'BGK',
            'BRadio', 'KMHDI', 'MABIDAR', 'Olahraga', 'PMKK',
            'Pramuka', 'SSEC'
        ];

        if (!in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }
        $pendaftarans = Pendaftaran::with(['user', 'setting'])->where('status', 'pending')->get();
        return view('layouts.admin.pendaftaran.index', compact('pendaftarans'));
    }

    /**
     * Perbarui status pendaftaran: diterima atau ditolak.
     */
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
