<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 5px;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input[type="email"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .message {
            text-align: center;
            margin: 10px 0;
            color: green;
        }
        .error {
            text-align: center;
            margin: 10px 0;
            color: red;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Forgot Password</h1>

    <!-- Flash Message for success or error -->
    @if(session('status'))
        <div class="message">{{ session('status') }}</div>
    @elseif ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Form to Request Password Reset Code and Verify Code -->
    <div>
        <form id="forgotPasswordForm" action="/forgot-password" method="POST">
            @csrf
            <div id="emailSection">
                <h2>Request Verification Code</h2>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email', session('email')) }}" required placeholder="Enter your email address">
                <button type="submit" id="sendCodeButton">Send Verification Code</button>
            </div>

            <div id="verificationCodeSection" class="{{ session('status') ? '' : 'hidden' }}">
                <h2>Enter Verification Code</h2>
                <label for="verification_code">Verification Code:</label>
                <input type="text" id="verification_code" name="verification_code" required placeholder="Enter the verification code">
                <button type="submit" id="verifyCodeButton">Verify Code</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailSection = document.getElementById('emailSection');
            const verificationCodeSection = document.getElementById('verificationCodeSection');
            const form = document.getElementById('forgotPasswordForm');
            const sendCodeButton = document.getElementById('sendCodeButton');
            const verifyCodeButton = document.getElementById('verifyCodeButton');

            @if(session('status'))
                emailSection.classList.add('hidden');
                verificationCodeSection.classList.remove('hidden');
                form.action = "/verify-code";
            @endif

            sendCodeButton.addEventListener('click', function(event) {
                event.preventDefault();
                form.action = "/forgot-password";
                form.submit();
            });

            verifyCodeButton.addEventListener('click', function(event) {
                event.preventDefault();
                form.action = "/verify-code";
                form.submit();
            });
        });
    </script>
</body>
</html>
