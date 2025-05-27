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
                        $isAnswered = in_array($qId, $answered);
                    @endphp
                    <button data-index="{{ $i }}"
                            class="question-button {{ $isAnswered ? 'answered' : '' }} {{ $i == $index ? 'current' : '' }}"
                            title="Soal {{ $i }}">
                        {{ $i }}
                    </button>
                @endfor
            </div>
        </div>

        <div class="container mt-4 pb-5" id="questionContainer">
            <!-- Konten soal akan diupdate via AJAX -->
            @include('layouts.mahasiswa.SPK.question_partial')
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleNav = document.getElementById('toggleNav');
    const questionNavBox = document.getElementById('questionNavBox');
    const questionContainer = document.getElementById('questionContainer');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Toggle navigasi soal
    toggleNav?.addEventListener('click', () => {
        const isHidden = questionNavBox.classList.toggle('hidden');
        toggleNav.classList.toggle('active');
        toggleNav.setAttribute('aria-expanded', !isHidden);
    });

    toggleNav?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleNav.click();
        }
    });

    // Fungsi untuk memuat soal berdasarkan index
    function loadQuestion(index) {
        fetch(`/spk/form/${index}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal memuat soal.');
            return response.text();
        })
        .then(html => {
            questionContainer.innerHTML = html;
            updateNavButtons(index);
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setupFormHandlers(); // Rebind setelah isi HTML diubah
        })
        .catch(error => {
            console.error('Error loading question:', error);
            alert('Gagal memuat soal.');
        });
    }

    // Fungsi untuk menandai tombol navigasi aktif
    function updateNavButtons(currentIndex) {
        const buttons = questionNavBox.querySelectorAll('.question-button');
        buttons.forEach(button => {
            const buttonIndex = parseInt(button.dataset.index);
            button.classList.toggle('current', buttonIndex === currentIndex);
        });
    }

    // Rebind semua event setelah soal termuat
    function setupFormHandlers() {
        const form = document.getElementById('questionForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                submitAnswer(this);
            });
        }

        const prevBtn = document.getElementById('prevBtn');
        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                const currentIndex = parseInt(this.dataset.currentIndex);
                if (currentIndex > 1) loadQuestion(currentIndex - 1);
            });
        }

        // Event handler untuk tombol navigasi langsung (jika ada)
        document.querySelectorAll('.question-button').forEach(button => {
            button.addEventListener('click', function () {
                const targetIndex = parseInt(this.dataset.index);
                loadQuestion(targetIndex);
            });
        });
    }

    // Submit jawaban
    function submitAnswer(form) {
        const formData = new FormData(form);
        const url = form.action;
        const currentIndex = parseInt(form.dataset.currentIndex);
        const isLastQuestion = form.dataset.isLastQuestion === 'true';

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tandai soal ini sebagai telah dijawab
                const buttons = questionNavBox.querySelectorAll('.question-button');
                buttons.forEach(button => {
                    if (parseInt(button.dataset.index) === currentIndex) {
                        button.classList.add('answered');
                    }
                });

                if (isLastQuestion && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    loadQuestion(currentIndex + 1);
                }
            } else {
                showError(data.message || 'Jawaban gagal dikirim.');
            }
        })
        .catch(() => {
            showError('Terjadi kesalahan saat mengirim jawaban.');
        });
    }

    // Tampilkan pesan error
    function showError(message) {
        const errorDiv = document.getElementById('errorMessage');
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        } else {
            alert(message);
        }
    }

    // Initial setup
    setupFormHandlers();
});
</script>

@endsection
