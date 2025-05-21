@extends('layouts.app')

@section('content')
<style>
    .question-nav-wrapper {
        position: absolute;
        top: 4.5rem;
        right: 1rem;
        z-index: 20;
        user-select: none;
    }

    .question-nav-box {
        margin-top: 2.8rem;
        padding: 0.75rem 1rem;
        max-width: 260px;
        max-height: 220px;
        overflow-y: auto;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: flex-start;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: #f8f9fa;
        transition: max-height 0.3s ease, padding 0.3s ease;
    }

    .question-nav-box.hidden {
        max-height: 0;
        padding-top: 0;
        padding-bottom: 0;
        overflow: hidden;
        border: none;
    }

    .question-button {
        display: inline-flex;
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
        border-radius: 6px;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #fff;
        background-color: #6c757d;
        cursor: pointer;
        user-select: none;
        border: none;
        transition: background-color 0.3s, border 0.3s;
    }

    .question-button.answered {
        background-color: #198754; /* hijau jika sudah dijawab */
    }

   .question-button.current {
    border: 2px solid #0d6efd;
    background-color: #0d6efd; /* latar biru untuk soal aktif */
}


    .toggle-nav {
        position: absolute;
        top: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 6px 10px;
        cursor: pointer;
        width: 40px;
        height: 38px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        user-select: none;
        z-index: 30;
    }

    .toggle-nav span {
        display: block;
        width: 22px;
        height: 2.5px;
        background-color: #333;
        border-radius: 1px;
        margin: 3px 0;
        transition: all 0.3s ease;
    }

    .toggle-nav.active span:nth-child(1) {
        transform: rotate(45deg);
        position: relative;
        top: 6px;
    }

    .toggle-nav.active span:nth-child(2) {
        opacity: 0;
    }

    .toggle-nav.active span:nth-child(3) {
        transform: rotate(-45deg);
        position: relative;
        top: -6px;
    }
</style>

<div class="main-content" style="position: relative;">
    <section class="section" style="min-height: calc(100vh - 150px); position: relative;">
        <div class="section-header">
            <h1>Tes Rekomendasi UKM</h1>
        </div>

        <div class="question-nav-wrapper" aria-label="Navigasi Soal">
            <div id="toggleNav" class="toggle-nav" role="button" tabindex="0" aria-expanded="false" aria-controls="questionNavBox" aria-label="Toggle navigasi soal">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div id="questionNavBox" class="question-nav-box hidden">
                @for ($i = 1; $i <= $total; $i++)
                    @php
                        $qId = $questions[$i - 1]->id;
                        $isAnswered = in_array($qId, $answered); // pengecekan benar
                    @endphp
                    <a href="{{ route('spk.form', ['index' => $i]) }}"
                       class="question-button {{ $isAnswered ? 'answered' : '' }} {{ $i == $index ? 'current' : '' }}"
                       title="Soal {{ $i }}">
                        {{ $i }}
                    </a>
                @endfor
            </div>
        </div>

        <div class="container mt-4 pb-5">
            <h2 class="mb-4">Soal {{ $index }} dari {{ $total }}</h2>

            <form action="{{ route('spk.answer', ['index' => $index]) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold" style="font-size: 1.25rem;">
                        {{ $question->question }}
                    </label>

                    <div class="mt-3">
                        @php $qId = $question->id; @endphp
                        @for ($i = 5; $i >= 1; $i--)
                            @php
                                $label = [
                                    5 => 'Sangat Setuju',
                                    4 => 'Setuju',
                                    3 => 'Netral',
                                    2 => 'Tidak Setuju',
                                    1 => 'Sangat Tidak Setuju',
                                ][$i];

                                // Ambil jawaban yang sudah disimpan untuk soal ini jika ada
                                $answeredValue = \App\Models\Answer::where('user_id', $user->id)->where('question_id', $qId)->value('value');
                            @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="value" id="option{{ $i }}" value="{{ $i }}"
                                       {{ $answeredValue == $i ? 'checked' : '' }} required>
                                <label class="form-check-label" for="option{{ $i }}">{{ $label }}</label>
                            </div>
                        @endfor
                    </div>

                    @error('value')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-5">
                    @if ($index > 1)
                        <a href="{{ route('spk.form', ['index' => $index - 1]) }}" class="btn btn-warning">← Kembali</a>
                    @else
                        <div></div>
                    @endif

                    <button type="submit" class="btn {{ $index == $total ? 'btn-success' : 'btn-primary' }}">
                        {{ $index == $total ? 'Lihat Hasil' : 'Lanjut →' }}
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    const toggleNav = document.getElementById('toggleNav');
    const questionNavBox = document.getElementById('questionNavBox');

    toggleNav.addEventListener('click', () => {
        const isHidden = questionNavBox.classList.toggle('hidden');
        toggleNav.classList.toggle('active');
        toggleNav.setAttribute('aria-expanded', !isHidden);
    });

    toggleNav.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleNav.click();
        }
    });
</script>
@endsection
