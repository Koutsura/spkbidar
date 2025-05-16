@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Hasil Rekomendasi UKM</h1>
        </div>

        <div class="section-body">
            <div class="mb-4">
                <h4>Data Mahasiswa</h4>
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>NIM:</strong> {{ $user->setting->nim ?? '-' }}</p>
                <p><strong>Jurusan:</strong> {{ $user->setting->jurusan ?? '-' }}</p>
            </div>

            <div class="mb-4">
                <h4>Skor per Kriteria</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <th>Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($criteriaScores as $criteria => $score)
                        <tr>
                            <td>{{ ucfirst($criteria) }}</td>
                            <td>{{ number_format($score, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mb-4">
                <h4>3 Rekomendasi UKM Terbaik</h4>
                <ol class="list-group list-group-numbered">
                    @foreach ($finalUKM['top_ukms'] as $ukm => $score)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            {{ $ukm }}
                            @if (stripos($ukm, 'Inovator Center') !== false)
                            <span class="badge badge-success ml-2">⭐ Direkomendasikan khusus!</span>
                            @endif
                        </span>
                        <span><strong>{{ number_format($score, 2) }}</strong></span>
                    </li>
                    @endforeach
                </ol>
            </div>

            @if ($finalUKM['description'])
            <div class="alert alert-info mt-4">
                <strong>Catatan:</strong> {{ $finalUKM['description'] }}
            </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('spk.export_pdf') }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-file-download"></i> Download Hasil PDF
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
