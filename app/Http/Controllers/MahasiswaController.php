<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();
        $setting = Setting::where('user_id', $user->id)->first();

        if (!$setting) {
            return redirect()->back()->with('error', 'Data profil belum lengkap.');
        }

        $pendaftaran = Pendaftaran::where('user_id', $user->id)->latest()->first();


        return view('layouts.mahasiswa.pendaftaran.form', compact('user', 'setting', 'pendaftaran'));
    }

    public function submitForm(Request $request)
{
    $request->validate([
        'organization_1' => 'required|string|max:100',
        'organization_2' => 'nullable|string|max:100',
        'organization_3' => 'nullable|string|max:100',
        'alamat' => 'required|string|max:255',
        'deskripsi' => 'required|string|max:500',
        'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:20480',
    ]);

    $user = Auth::user();
    $setting = Setting::where('user_id', $user->id)->first();

    if (!$setting) {
        return redirect()->back()->with('error', 'Data setting tidak ditemukan.');
    }

    // Simpan file baru
    $originalName = preg_replace('/\s+/', '_', strtolower($request->file('file')->getClientOriginalName()));
    $filename = time() . '_' . $originalName;
    $path = 'uploads/pendaftaran/' . $filename;
    $request->file('file')->storeAs('uploads/pendaftaran', $filename, 'public');

    // Cari pendaftaran sebelumnya (tanpa filter status)
 $pendaftaran = Pendaftaran::where('user_id', $user->id)
                                   ->where('status', 'pending')
                                   ->first();

    if ($pendaftaran) {
        // Hapus file lama jika ada
        if ($pendaftaran->upload_file && Storage::disk('public')->exists($pendaftaran->upload_file)) {
            Storage::disk('public')->delete($pendaftaran->upload_file);
        }

        $pendaftaran->update([
            'organization_1' => $request->organization_1,
            'organization_2' => $request->organization_2,
            'organization_3' => $request->organization_3,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'upload_file' => $path,
            'status' => 'pending', // update status jadi pending saat daftar ulang
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil diperbarui.');
    } else {
        // Buat data baru
        Pendaftaran::create([
            'user_id' => $user->id,
            'setting_id' => $setting->id,
            'organization_1' => $request->organization_1,
            'organization_2' => $request->organization_2,
            'organization_3' => $request->organization_3,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'upload_file' => $path,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim.');
    }
}

}
