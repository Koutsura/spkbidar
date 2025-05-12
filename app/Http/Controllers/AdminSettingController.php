<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    // Tampilkan semua mahasiswa
    public function index(Request $request)
    {
        $search = $request->get('search');

    if ($search) {
        $users = User::where('role', 'mahasiswa')
            ->where('name', 'like', "%{$search}%")
            ->get();
    } else {
        $users = User::where('role', 'mahasiswa')->get();
    }

    return view('layouts.setting_admin.index', compact('users'));

    }

    // Tampilkan halaman edit organisasi mahasiswa
    public function edit(User $user)
    {
        // Pastikan hanya yang memiliki akses yang bisa mengedit
        if (!auth()->check()) {
            abort(403, 'Hanya pengguna yang terautentikasi yang dapat mengedit organisasi.');
        }

        $setting = $user->setting ?: new Setting(); // Default jika belum ada setting
        return view('layouts.setting_admin.edit', compact('user', 'setting'));
    }

    // Update organisasi mahasiswa
    public function update(Request $request, User $user)
    {
        // Pastikan hanya yang memiliki akses yang bisa memperbarui organisasi
        if (!auth()->check()) {
            abort(403, 'Hanya pengguna yang terautentikasi yang dapat memperbarui organisasi.');
        }

        // Validasi input organisasi
        $validated = $request->validate([
            'organization_1' => 'nullable|string|max:255',
            'organization_2' => 'nullable|string|max:255',
            'organization_3' => 'nullable|string|max:255',
        ]);

        // Ambil setting atau buat yang baru jika belum ada
        $setting = $user->setting ?: new Setting(['user_id' => $user->id]);
        $setting->fill($validated);
        $setting->user_id = $user->id;
        $setting->save();

        // Redirect dengan pesan sukses
        return redirect()->route('setting_admin.index', $user->id)
                         ->with('success', 'Organisasi berhasil diperbarui.');
    }
}



