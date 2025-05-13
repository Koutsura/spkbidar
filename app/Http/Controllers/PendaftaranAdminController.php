<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranAdminController extends Controller
{
    public function index()
    {
        $pendaftarans = Pendaftaran::with(['user', 'setting'])->where('status', 'pending')->get();
        return view('layouts.admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function updateStatus($id, $status)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        if (in_array($status, ['diterima', 'ditolak'])) {
            $pendaftaran->status = $status;
            $pendaftaran->save();
        }

        return redirect()->back()->with('success', 'Status pendaftaran diperbarui.');
    }
}

