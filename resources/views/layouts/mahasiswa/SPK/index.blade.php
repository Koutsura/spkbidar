@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tes Rekomendasi Unit Kegiatan Mahasiswa (UKM)</h1>
        </div>

        <div class="section-body d-flex justify-content-center mt-5">
            <div class="text-center">
                <h2 class="mb-3">Silakan mulai Tes Rekomendasi UKM</h2>
                <p class="mb-4">
                    Tes ini bertujuan untuk membantu Anda menemukan organisasi UKM yang paling sesuai
                    dengan minat dan potensi Anda. Jawaban Anda akan tersimpan secara otomatis, sehingga
                    Anda dapat menyelesaikan tes secara bertahap dan melanjutkannya di lain waktu.
                </p>
                <a href="{{ route('spk.question', ['index' => 1]) }}"
                   class="btn btn-primary px-4 py-2">
                    Mulai Tes
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
