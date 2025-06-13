<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::where('user_id', auth()->id())->first();

        if (!$setting) {
            $setting = new Setting(); // agar tetap bisa digunakan di view
        }

        return view('layouts.settings.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'tahun_angkatan' => 'required|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
        ]);

        $setting = Setting::where('user_id', auth()->id())->first();
        $path = $setting->profile_photo ?? null;

        // Simpan file jika diupload ulang
        if ($request->hasFile('profile_photo')) {
            // Hapus file lama jika ada
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            // Menyimpan file dengan nama yang sesuai
            $filename = time() . '.' . $request->file('profile_photo')->getClientOriginalExtension();
            $path = $request->file('profile_photo')->storeAs('profile_photos', $filename, 'public');
        }

        if ($setting) {
            $setting->update([
                'nim' => $request->nim,
                'phone_number' => $request->phone_number,
                'jurusan' => $request->jurusan,
                'tahun_angkatan' => $request->tahun_angkatan,
                'profile_photo' => $path,
            ]);
        } else {
            Setting::create([
                'user_id' => auth()->id(),
                'nim' => $request->nim,
                'phone_number' => $request->phone_number,
                'jurusan' => $request->jurusan,
                'tahun_angkatan' => $request->tahun_angkatan,
                'profile_photo' => $path,
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Profil berhasil disimpan.');
    }
}
