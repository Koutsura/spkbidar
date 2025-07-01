@extends('layouts.app')

@section('title', 'Hasil Rekomendasi UKM')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Hasil Rekomendasi UKM</h1>
        </div>
        <div class="container">
            {{-- Nilai Per Kriteria --}}
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

            {{-- 3 Rekomendasi UKM Teratas (SAW) --}}
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

            {{-- Hasil Prediksi KNN --}}
            @if(isset($knnPredictions) && count($knnPredictions) > 0)
            <div class="card mb-4">
                <div class="card-header">Rekomendasi Bonus</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($knnPredictions as $ukmTest => $predictedClass)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Data UKM: <strong>{{ $ukmTest }}</strong></span>
                                <span>Prediksi Kelas Terdekat: <strong>{{ $predictedClass }}</strong></span>
                            </li>
                        @endforeach
                    </ul>
                    <small class="text-muted d-block mt-2">
                        * Hasil rekomendasi prediksi ini digunakan kalau mahasiswa mau fokus 1 bidang UKM aja, jika mau ambil UKM prediksi ini mahasiswa harus mengikuti salah satu UKM dari 3 teratas rekomendasi UKM diatas.
                    </small>
                </div>
            </div>
            @endif

            <div class="text-center my-4">
                <a href="{{ route('spk.export_pdf') }}" class="btn btn-danger btn-lg shadow-sm px-4 py-2">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i> Download PDF
                </a>
            </div>

        </div>
    </section>
</div>
@endsection
