<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
    <form action="/forgot-password" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Send Password Reset Link</button>
    </form>
</body>
</html>
