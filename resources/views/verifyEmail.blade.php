<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Website UKM Bina Darma" />
    <meta name="keywords" content="UKM,Universitas Bina Darma,Unit Kegiatan Mahasiswa,website,organisasi" />
    <meta name="author" content="Universitas Bina Darma, M. Denny Tri Lisandi" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />
    <title>Email Verification</title>
    <!-- Favicon -->
  <link rel="icon" href="{{ asset('img/tab.webp') }}" type="img/webp" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <style>
         .otp-input {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .otp-input input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            border: 2px solid #ced4da;
            border-radius: 4px;
        }
        .otp-input input:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        @media (max-width: 576px) {
            .otp-input input {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }
        }

        .simple-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            z-index: 1000;
            display: none;
        }
        .simple-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(0,0,0,.1);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-4 text-center">
                        <h2 class="card-title mb-4">Verification</h2>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <p class="text-muted mb-4">
                            Silakan periksa email Anda, kami telah mengirimkan kode ke
                            <strong>{{ session('pending_email') ?? 'your email' }}</strong>. Masukkan di bawah.
                        </p>

                        <form action="{{ url('/verify-email') }}" method="POST">
                            @csrf
                            <div class="otp-input mb-3 d-flex justify-content-center" id="otp-container">
                                @for ($i = 0; $i < 6; $i++)
                                <input type="text"
                            name="code[]"
                            class="form-control d-inline-block text-center"
                            maxlength="1"
                            required
                            pattern="[0-9a-zA-Z]*"
                            inputmode="text"
                            data-index="{{ $i }}">

                                @endfor
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Continue</button>
                        </form>

                        <form id="resend-form" action="{{ url('/resend-code') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="pending_email" value="{{ session('pending_email') }}">
                            <button type="submit" class="btn btn-link p-0 text-decoration-none" id="resend-btn">
                                Tidak mendapatkan kode? <strong>Kirim kode baru</strong>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.otp-input input');
        const otpContainer = document.getElementById('otp-container');

        // Improved typing handling
        inputs.forEach((input, index) => {
            // Handle typing
            input.addEventListener('input', (e) => {
                // Only allow numbers
                if (!/^[a-zA-Z0-9]*$/.test(input.value)) {
                    input.value = '';
                    return;
                }

                // Auto-focus next input if current has value
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                // Auto submit if last digit is entered
                if (index === inputs.length - 1 && input.value.length === 1) {
                    const allFilled = Array.from(inputs).every(i => i.value.length === 1);
                    if (allFilled) {
                        input.form.submit();
                    }
                }
            });

            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Handle arrow keys for navigation
            input.addEventListener('keyup', (e) => {
                if (e.key === 'ArrowLeft' && index > 0) {
                    inputs[index - 1].focus();
                } else if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            // Prevent non-numeric input
            input.addEventListener('keypress', (e) => {
                if (!/[a-zA-Z0-9]/.test(e.key)) e.preventDefault();
            });
        });

        // Improved paste handling
        otpContainer.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasteData = (e.clipboardData || window.clipboardData).getData('text');
            const cleanPaste = pasteData.replace(/[^a-zA-Z0-9]/g, '').substring(0, 6);// Remove non-digits and limit to 6 chars

            if (cleanPaste.length === 6) {
                // Fill all inputs with the pasted data
                inputs.forEach((input, index) => {
                    input.value = cleanPaste[index];
                });

                // Focus on the last input
                inputs[inputs.length - 1].focus();
            }
        });

        // Allow selecting all inputs with Ctrl+A
        otpContainer.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 'a') {
                e.preventDefault();
                inputs.forEach(input => input.select());
            }
        });

        // Resend AJAX
        const resendForm = document.getElementById('resend-form');
        const resendBtn = document.getElementById('resend-btn');

        resendForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const originalText = resendBtn.innerHTML;
            resendBtn.disabled = true;

            const spinner = document.createElement('span');
            spinner.className = typeof bootstrap !== 'undefined' ? 'spinner-border spinner-border-sm' : 'simple-spinner';
            resendBtn.innerHTML = '';
            resendBtn.appendChild(spinner);
            resendBtn.append(' Sending...');

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'Failed to resend code');

                // Toast success
                if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
                    const toast = document.createElement('div');
                    toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
                    toast.innerHTML = `
                        <div class="d-flex">
                            <div class="toast-body">${data.message || 'New code sent!'}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    `;
                    document.body.appendChild(toast);
                    new bootstrap.Toast(toast).show();
                    setTimeout(() => toast.remove(), 5000);
                } else {
                    const fallback = document.createElement('div');
                    fallback.className = 'simple-toast';
                    fallback.textContent = data.message || 'New code sent!';
                    document.body.appendChild(fallback);
                    fallback.style.display = 'block';
                    setTimeout(() => {
                        fallback.style.display = 'none';
                        fallback.remove();
                    }, 3000);
                }

            } catch (err) {
                alert(err.message || 'Failed to resend code.');
            } finally {
                resendBtn.innerHTML = originalText;
                setTimeout(() => resendBtn.disabled = false, 30000);
            }
        });
    });
    </script>
</body>
</html>
