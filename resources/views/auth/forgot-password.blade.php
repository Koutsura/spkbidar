<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Forgot Password</h3>

                        {{-- Alert --}}
                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Form kirim kode --}}
                        <form id="sendCodeForm" method="POST" action="{{ url('/forgot-password') }}"
                              class="{{ session('step') === 'code' ? 'd-none' : '' }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', session('email')) }}"
                                    class="form-control"
                                    placeholder="Enter your email"
                                    required
                                >
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Verification Code</button>
                        </form>

                        {{-- Form verifikasi kode --}}
                        <form id="verifyForm" method="POST" action="{{ url('/verify-code') }}"
                              class="{{ session('step') === 'code' ? '' : 'd-none' }}">
                            @csrf

                            <p class="mb-3">
                                We've sent a 6-digit verification code to <strong>{{ session('email') }}</strong>
                            </p>

                            <input type="hidden" name="email" value="{{ session('email') }}">

                            <div class="mb-3">
                                <label for="verification_code" class="form-label">Verification Code</label>
                                <input
                                    type="text"
                                    name="verification_code"
                                    id="verification_code"
                                    class="form-control"
                                    placeholder="Enter 6-digit code"
                                    maxlength="6"
                                    pattern="\d{6}"
                                    title="Please enter a 6-digit code"
                                    required
                                    autofocus
                                >
                            </div>

                            <button type="submit" class="btn btn-success w-100">Verify Code</button>
                        </form>

                        {{-- Resend --}}
                        @if(session('step') === 'code')
                            <form method="POST" action="/resend-code" class="mt-3">
                                @csrf
                                <input type="hidden" name="email" value="{{ session('email') }}">
                                <button type="submit" class="btn btn-outline-primary w-100">Resend Code</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const verifyForm = document.getElementById('verifyForm');
            const verificationCodeInput = document.getElementById('verification_code');

            if (verifyForm && verificationCodeInput) {
                verifyForm.addEventListener('submit', function (event) {
                    if (verificationCodeInput.value.trim() === '') {
                        event.preventDefault();
                        alert('Please enter a 6-digit verification code.');
                        verificationCodeInput.focus();
                    }
                });
            }
        });
    </script>
</body>
</html>
