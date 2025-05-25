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
<div class="container mb-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Rekomendasi Bonus
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-md-9 col-sm-12">
                            <span class="d-block font-weight-bold">{{ $bonusUKM }}</span>
                            <span class="badge badge-success mt-2 d-inline-block">
                                ⭐ Direkomendasikan karena skor tinggi pada Kreativitas, Keaktifan, Teknologi, dan Inovatif
                            </span>
                        </div>
                        <div class="col-md-3 col-sm-12 text-md-right text-left mt-3 mt-md-0">
                            <strong>{{ number_format($bonusScore, 2) }}</strong>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endif


    <div class="text-center my-4">
    <a href="{{ route('spk.export_pdf') }}" class="btn btn-danger btn-lg shadow-sm px-4 py-2">
        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Export Hasil ke PDF
    </a>
</div>

</div>
</section>
</div>
@endsection
