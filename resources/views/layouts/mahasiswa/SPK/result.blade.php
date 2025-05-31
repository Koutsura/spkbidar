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
                <div class="card-header">3 Rekomendasi UKM Teratas (SAW)</div>
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
                <div class="card-header">Hasil Prediksi KNN dari 3 Rekomendasi Teratas</div>
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
                        * Prediksi ini berdasarkan algoritma K-Nearest Neighbors (KNN) dengan k=3.
                    </small>
                </div>
            </div>
            @endif

            {{-- Rekomendasi Bonus --}}
@if ($showBonus)
<div class="container mb-4">
    {{-- Seluruh Card Bisa Diklik --}}
   <div class="card" id="bonusCard" style="cursor: pointer;">
        <div class="card-header bg-primary text-white">
            Rekomendasi Bonus
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row align-items-start">
                        <div class="col-12 col-md-9">
                            <div class="mb-2">
                                <span class="d-block fw-bold">{{ $bonusUKM }}</span>
                            </div>
                            <div>
                                <span class="badge bg-success text-wrap" style="white-space: normal;">
                                    ⭐ Direkomendasikan karena skor tinggi pada <strong>Kreativitas</strong>, <strong>Keaktifan</strong>, <strong>Teknologi</strong>, dan <strong>Inovatif</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 text-md-end text-start mt-3 mt-md-0">
                            <strong>{{ number_format($bonusScore, 2) }}</strong>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Manual Popup -->
<div id="manualModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
  background: rgba(0,0,0,0.6); z-index:1050; align-items:center; justify-content:center;">
  <div style="background:#fff; max-width:400px; width:90%; border-radius:8px; padding:20px; position:relative;">
    <button id="closeModal" style="position:absolute; top:10px; right:15px; background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
    <h5>Inovator Center (DIIB)</h5>
    <img src="{{ asset('img/inovator.webp') }}" class="img-fluid mb-3" alt="Inovator Center" />
    <p>Inovator Center(@inovator.center)</p>
    <p class="text-muted small">
      Direkomendasikan karena skor tinggi pada kreativitas, keaktifan, teknologi, dan inovatif.
    </p>
  </div>
</div>

<script>
  document.getElementById('bonusCard').addEventListener('click', function() {
    document.getElementById('manualModal').style.display = 'flex';
  });

  document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('manualModal').style.display = 'none';
  });

  // Close modal jika klik di luar box popup
  document.getElementById('manualModal').addEventListener('click', function(e) {
    if(e.target === this) {
      this.style.display = 'none';
    }
  });
</script>
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
