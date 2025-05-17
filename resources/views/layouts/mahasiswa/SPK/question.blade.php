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

                    <div class="mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="value" id="option5" value="5" required>
                            <label class="form-check-label" for="option5">Sangat Setuju</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="value" id="option4" value="4">
                            <label class="form-check-label" for="option4">Setuju</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="value" id="option3" value="3">
                            <label class="form-check-label" for="option3">Netral</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="value" id="option2" value="2">
                            <label class="form-check-label" for="option2">Tidak Setuju</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="value" id="option1" value="1">
                            <label class="form-check-label" for="option1">Sangat Tidak Setuju</label>
                        </div>
                    </div>

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
