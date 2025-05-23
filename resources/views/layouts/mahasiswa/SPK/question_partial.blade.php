<h2 class="mb-4">Soal {{ $index }} dari {{ $total }}</h2>

<form id="questionForm" action="{{ route('spk.answer', ['index' => $index]) }}" method="POST"
      data-current-index="{{ $index }}"
      data-is-last-question="{{ $index == $total ? 'true' : 'false' }}">
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

                    $answeredValue = \App\Models\Answer::where('user_id', $user->id)->where('question_id', $qId)->value('value');
                @endphp
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="value" id="option{{ $i }}" value="{{ $i }}"
                           {{ $answeredValue == $i ? 'checked' : '' }} required>
                    <label class="form-check-label" for="option{{ $i }}">{{ $label }}</label>
                </div>
            @endfor
        </div>

        <div id="errorMessage" class="text-danger mt-2" style="display: none;"></div>
    </div>

    <div class="d-flex justify-content-between mt-5">
        @if ($index > 1)
            <button type="button" id="prevBtn" class="btn btn-warning" data-current-index="{{ $index }}">← Kembali</button>
        @else
            <div></div>
        @endif

        <button type="submit" class="btn {{ $index == $total ? 'btn-success' : 'btn-primary' }}">
            {{ $index == $total ? 'Lihat Hasil' : 'Lanjut →' }}
        </button>
    </div>
</form>
