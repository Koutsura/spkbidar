@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Hasil Skor (UKM)</h1>
        </div>
<h1>Hasil Sistem Pendukung Keputusan</h1>

<p>Nama: {{ $user->name }}</p>
<p>NIM: {{ $user->setting->nim ?? '-' }}</p>
<p>Jurusan: {{ $user->setting->jurusan ?? '-' }}</p>

<h3>Skor per Kriteria:</h3>
<ul>
    @foreach ($criteriaScores as $criteria => $score)
    <li>{{ $criteria }}: {{ $score }}</li>
    @endforeach
</ul>

<h3>Rekomendasi UKM Terbaik:</h3>
<ol>
    @foreach ($finalUKM['top_ukms'] as $ukm => $score)
    <li>{{ $ukm }} (Skor: {{ number_format($score, 2) }})</li>
    @endforeach
</ol>

@if ($finalUKM['description'])
<p><strong>Catatan:</strong> {{ $finalUKM['description'] }}</p>
@endif

<a href="{{ route('spk.export_pdf') }}" target="_blank">Download Hasil PDF</a>
</section>
</div>
@endsection
