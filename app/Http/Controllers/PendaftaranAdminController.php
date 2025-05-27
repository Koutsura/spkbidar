<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Setting;
use Illuminate\Http\Request;

class PendaftaranAdminController extends Controller
{
    /**
     * Tampilkan daftar pendaftaran dengan status pending.
     */
    public function index()
    {
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

        // Ambil data setting berdasarkan user_id
        $setting = Setting::where('user_id', $pendaftaran->user_id)->first();

        if ($setting) {
            if ($status === 'diterima') {
                $setting->organization_1 = $pendaftaran->organization_1;
                $setting->organization_2 = $pendaftaran->organization_2;
                $setting->organization_3 = $pendaftaran->organization_3;
            } elseif ($status === 'ditolak') {
                $setting->organization_1 = null;
                $setting->organization_2 = null;
                $setting->organization_3 = null;
            }

            $setting->save();
        }

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
