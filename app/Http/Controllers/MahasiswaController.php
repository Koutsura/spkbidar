<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Tampilkan form pendaftaran.
     */
    public function showForm()
{
    $user = Auth::user();
    $setting = Setting::where('user_id', $user->id)->first();

    if (!$setting) {
        return redirect()->back()->with('error', 'Data profil belum lengkap.');
    }

    $pendaftaran = Pendaftaran::where('user_id', $user->id)
                               ->where('status', 'pending')
                               ->first();

    return view('layouts.mahasiswa.pendaftaran.form', compact('user', 'setting', 'pendaftaran'));
}


    /**
     * Simpan data pendaftaran.
     */
   public function submitForm(Request $request)
{
    // Validasi input
    $request->validate([
        'organization_1' => 'required|string|max:100',
        'organization_2' => 'nullable|string|max:100',
        'organization_3' => 'nullable|string|max:100',
        'alamat' => 'required|string|max:255',
        'deskripsi' => 'required|string|max:500',
        'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // File tidak wajib saat update
    ]);

    $user = Auth::user();
    $setting = Setting::where('user_id', $user->id)->first();

    if (!$setting) {
        return redirect()->back()->with('error', 'Data setting tidak ditemukan.');
    }

    // Cek apakah sudah pernah mendaftar (status 'pending')
    $pendaftaran = Pendaftaran::where('user_id', $user->id)
                               ->where('status', 'pending')
                               ->first();

    // Upload file jika ada, jika tidak biarkan file lama tetap ada
    $path = null;
    if ($request->hasFile('file')) {
        $originalName = preg_replace('/\s+/', '_', strtolower($request->file('file')->getClientOriginalName()));
        $filename = time() . '_' . $originalName;
        $path = 'uploads/pendaftaran/' . $filename;
        $request->file('file')->storeAs('uploads/pendaftaran', $filename, 'public');
    }

    if ($pendaftaran) {
        // Hapus file lama jika ada dan file baru di-upload
        if ($path && $pendaftaran->file && Storage::disk('public')->exists($pendaftaran->file)) {
            Storage::disk('public')->delete($pendaftaran->file);
        }

        // Update data pendaftaran lama
        $pendaftaran->update([
            'organization_1' => $request->organization_1,
            'organization_2' => $request->organization_2,
            'organization_3' => $request->organization_3,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'file' => $path ?? $pendaftaran->file, // Gunakan file lama jika tidak ada file baru
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil diperbarui.');
    } else {
        // Jika belum pernah daftar, buat data baru
        Pendaftaran::create([
            'user_id' => $user->id,
            'setting_id' => $setting->id,
            'organization_1' => $request->organization_1,
            'organization_2' => $request->organization_2,
            'organization_3' => $request->organization_3,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'file' => $path,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim.');
    }
}



}
