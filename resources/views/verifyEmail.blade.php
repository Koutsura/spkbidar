<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    @if (session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    <p>Please enter the verification code sent to your email:</p>
    <form action="{{ url('/verify-email') }}" method="POST">
        @csrf
        <input type="text" name="verification_code" required>
        <button type="submit">Verify Email</button>
    </form>
</body>
</html>
