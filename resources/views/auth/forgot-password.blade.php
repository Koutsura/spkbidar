<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #2d3748;
            line-height: 1.6;
            padding: 0;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .container {
            max-width: 28rem;
            width: 90%;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        input[type="email"],
        input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 1rem;
        }

        input[type="email"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #3490dc;
            box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.2);
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #3490dc;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2779bd;
        }

        .btn-success {
            background-color: #38c172;
            color: white;
        }

        .btn-success:hover {
            background-color: #2d995b;
        }

        .btn-resend {
            margin-top: 0.75rem;
            background-color: white;
            color: #3490dc;
            border: 1px solid #3490dc;
        }

        .btn-resend:hover {
            background-color: rgba(52, 144, 220, 0.1);
        }

        .alert {
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 0.375rem;
        }

        .alert-success {
            background-color: rgba(56, 193, 114, 0.1);
            color: #38c172;
            border: 1px solid rgba(56, 193, 114, 0.2);
        }

        .alert-danger {
            background-color: rgba(227, 52, 47, 0.1);
            color: #e3342f;
            border: 1px solid rgba(227, 52, 47, 0.2);
        }

        .hidden {
            display: none;
        }

        @media (max-width: 640px) {
            .container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Form kirim kode --}}
        <form id="sendCodeForm" method="POST" action="{{ url('/forgot-password') }}" novalidate class="{{ session('step') === 'code' ? 'hidden' : '' }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', session('email')) }}"
                    placeholder="Enter your email address"
                    required
                >
            </div>
            <button type="submit" class="btn btn-primary" id="sendCodeBtn">Send Verification Code</button>
        </form>

        {{-- Form verifikasi kode --}}
        <form id="verifyForm" method="POST" action="{{ url('/verify-code') }}" novalidate class="{{ session('step') === 'code' ? '' : 'hidden' }}">
            @csrf
            <p style="margin-bottom: 1rem;">
                We've sent a 6-digit verification code to <strong>{{ session('email') }}</strong>
            </p>

            <input type="hidden" name="email" value="{{ session('email') }}">

            <div class="form-group">
                <label for="verification_code">Verification Code</label>
                <input
                    type="text"
                    name="verification_code"
                    id="verification_code"
                    placeholder="Enter 6-digit code"
                    maxlength="6"
                    pattern="\d{6}"
                    title="Please enter a 6-digit code"
                    required
                    autofocus
                >
            </div>

            <button type="submit" class="btn btn-success" id="verifyCodeBtn">Verify Code</button>
        </form>

        {{-- Tombol resend --}}
        @if(session('step') === 'code')
            <form method="POST" action="/resend-code">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">
                <button type="submit" class="btn btn-resend" id="resendCodeBtn">Resend Code</button>
            </form>
        @endif
    </div>

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
