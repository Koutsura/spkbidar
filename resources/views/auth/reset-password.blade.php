<!-- resources/views/auth/reset-password.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reset-password.post') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="password">New Password</label>
            <input type="password" name="password" required autofocus>
        </div>

        <div>
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
