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
        $user = Auth::user();
        $setting = Setting::where('user_id', $user->id)->first();

        if (!$setting) {
            return redirect()->back()->with('error', 'Data setting tidak ditemukan.');
        }

        // Validasi dinamis hanya untuk organisasi yang belum diisi
        $rules = [
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:500',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:20480',
        ];

        if (!$setting->organization_1) {
            $rules['organization_1'] = 'required|string|max:100';
        }

        if (!$setting->organization_2) {
            $rules['organization_2'] = 'nullable|string|max:100';
        }

        if (!$setting->organization_3) {
            $rules['organization_3'] = 'nullable|string|max:100';
        }

        $request->validate($rules);

        // Cegah manipulasi input organisasi yang sudah terkunci
        if ($setting->organization_1 && $request->organization_1 !== $setting->organization_1) {
            return redirect()->back()->with('error', 'Organisasi 1 tidak dapat diubah.');
        }
        if ($setting->organization_2 && $request->organization_2 !== $setting->organization_2) {
            return redirect()->back()->with('error', 'Organisasi 2 tidak dapat diubah.');
        }
        if ($setting->organization_3 && $request->organization_3 !== $setting->organization_3) {
            return redirect()->back()->with('error', 'Organisasi 3 tidak dapat diubah.');
        }

        // Simpan file
        $originalName = preg_replace('/\s+/', '_', strtolower($request->file('file')->getClientOriginalName()));
        $filename = time() . '_' . $originalName;
        $path = 'uploads/pendaftaran/' . $filename;
        $request->file('file')->storeAs('uploads/pendaftaran', $filename, 'public');

        // Cari pendaftaran pending yang sudah ada
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->where('status', 'pending')->first();

        // Data dasar
        $data = [
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'upload_file' => $path,
            'status' => 'pending',
        ];

        // Simpan organisasi baru jika belum terkunci di settings
       if (!$setting->organization_1 && $request->filled('organization_1')) {
    $data['organization_1'] = $request->organization_1;
        } elseif ($setting->organization_1) {
    $data['organization_1'] = $setting->organization_1;
    }


        if (!$setting->organization_2 && $request->filled('organization_2')) {
            $data['organization_2'] = $request->organization_2;
             } elseif ($setting->organization_2) {
    $data['organization_2'] = $setting->organization_2;

        }

        if (!$setting->organization_3 && $request->filled('organization_3')) {
            $data['organization_3'] = $request->organization_3;
             } elseif ($setting->organization_3) {
    $data['organization_3'] = $setting->organization_3;
        }

        try {
    if ($pendaftaran) {
        // Hapus file lama
        if ($pendaftaran->upload_file && Storage::disk('public')->exists($pendaftaran->upload_file)) {
            Storage::disk('public')->delete($pendaftaran->upload_file);
        }

        // Jangan kosongkan field yang tidak dikirim
        $data['organization_1'] = $pendaftaran->organization_1 ?? $setting->organization_1;
        $data['organization_2'] = $data['organization_2'] ?? $pendaftaran->organization_2 ?? $setting->organization_2;
        $data['organization_3'] = $data['organization_3'] ?? $pendaftaran->organization_3 ?? $setting->organization_3;

        $pendaftaran->update($data);
        return redirect()->back()->with('success', 'Pendaftaran berhasil diperbarui.');
    } else {
        // Pendaftaran baru
        $data['organization_1'] = $data['organization_1'] ?? $setting->organization_1;
        $data['organization_2'] = $data['organization_2'] ?? $setting->organization_2;
        $data['organization_3'] = $data['organization_3'] ?? $setting->organization_3;

        Pendaftaran::create(array_merge($data, [
            'user_id' => $user->id,
            'setting_id' => $setting->id,
        ]));

        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim.');
    }
} catch (\Exception $e) {
    return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
}

    }
}
