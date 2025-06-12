<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
{
    // Ambil semua tahun angkatan
    $years = DB::table('settings')
        ->select('tahun_angkatan')
        ->distinct()
        ->orderBy('tahun_angkatan')
        ->pluck('tahun_angkatan')
        ->toArray();

    // Jumlah TES: dari results → users → settings (settings.user_id = users.id)
    $tesByYear = DB::table('results')
        ->join('users', 'results.user_id', '=', 'users.id')
        ->join('settings', 'users.id', '=', 'settings.user_id')
        ->select('settings.tahun_angkatan', DB::raw('COUNT(DISTINCT results.user_id) as jumlah'))
        ->groupBy('settings.tahun_angkatan')
        ->pluck('jumlah', 'tahun_angkatan')
        ->toArray();

    // Jumlah PENDAFTARAN: dari pendaftarans → settings
    $daftarByYear = DB::table('pendaftarans')
        ->join('settings', 'pendaftarans.setting_id', '=', 'settings.id')
        ->select('settings.tahun_angkatan', DB::raw('COUNT(DISTINCT pendaftarans.user_id) as jumlah'))
        ->groupBy('settings.tahun_angkatan')
        ->pluck('jumlah', 'tahun_angkatan')
        ->toArray();

    // Final chart data
    $userChartData = [];
    $pendaftarChartData = [];

    foreach ($years as $year) {
        $userChartData[] = $tesByYear[$year] ?? 0;
        $pendaftarChartData[] = $daftarByYear[$year] ?? 0;
    }

    return view('welcome', [
        'years' => $years,
        'userChartData' => $userChartData,
        'pendaftarChartData' => $pendaftarChartData,
    ]);
}



}
