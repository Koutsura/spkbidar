@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tes Rekomendasi UKM</h1>
        </div>

        <div class="container mt-4">
            <h2 class="mb-4">Soal {{ $index }} dari {{ $total }}</h2>

            <form action="{{ route('spk.answer', ['index' => $index]) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold" style="font-size: 1.25rem;">
                        {{ $question->question }}
                    </label>

                    <select name="value" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Jawaban --</option>
                        <option value="5">Sangat Setuju</option>
                        <option value="4">Setuju</option>
                        <option value="3">Netral</option>
                        <option value="2">Tidak Setuju</option>
                        <option value="1">Sangat Tidak Setuju</option>
                    </select>

                    @error('value')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ $index == $total ? 'Lihat Hasil' : 'Lanjut' }}
                </button>
            </form>
        </div>
    </section>
</div>
@endsection
