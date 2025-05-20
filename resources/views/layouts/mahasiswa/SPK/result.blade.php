@extends('layouts.app')

@section('title', 'Hasil Rekomendasi UKM')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Hasil Rekomendasi UKM</h1>
        </div>
<div class="container">
    <div class="card mb-4">
        <div class="card-header">Nilai Per Kriteria</div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($criteriaScores as $criteria => $score)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ ucfirst($criteria) }}
                        <span class="badge badge-primary badge-pill">{{ number_format($score, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

   <div class="card mb-4">
    <div class="card-header">3 Rekomendasi UKM Teratas</div>
    <div class="card-body">
        <ul class="list-group">
            @foreach($finalUKM as $ukm => $score)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        {{ $ukm }}
                        <span class="badge badge-success badge-pill">{{ number_format($score, 2) }}</span>
                    </div>

                    {{-- Tambahan deskripsi jika UKM Keagamaan --}}
                    @if($ukm === 'UKM Keagamaan')
                        <div class="mt-2 text-muted small">
                            Islam: <strong>UKM LDK ALQORIB</strong>, Kristen: <strong>UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK)</strong>, Hindu: <strong>UKM Kesatuan Mahasiswa Hindu Darma Indonesia (KMHDI)</strong>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>


    {{-- Rekomendasi Bonus --}}
    @if ($showBonus)
    <div class="card mb-4">
        <div class="card-header">Rekomendasi Bonus</div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        {{ $bonusUKM }}
                        <span class="badge badge-success ml-2">⭐ Direkomendasikan karena skor tinggi pada Kreativitas,keaktifan,Teknologi,dan inovatif</span>
                    </span>
                    <span><strong>{{ number_format($bonusScore, 2) }}</strong></span>
                </li>
            </ul>
        </div>
    </div>
    @endif

    <div class="text-center">
        <a href="{{ route('spk.export_pdf') }}" class="btn btn-danger">Export PDF</a>
    </div>
</div>
</section>
</div>
@endsection
