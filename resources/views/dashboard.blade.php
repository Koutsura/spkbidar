<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Logged In</title>
</head>
<body>
    <header>
        <h1>Welcome, {{ Auth::user()->name }}</h1>
        <nav>
            <ul>
                <li><a href="">Profile</a></li>
                <li><a href="">Settings</a></li>
               <li><a href="/">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Your Dashboard</h2>
            <p>Welcome back, {{ Auth::user()->name }}! Here you can manage your account, settings, and more.</p>
        </section>
        <section>
            <h3>Recent Activities</h3>
            <ul>
                <li>Activity 1</li>
                <li>Activity 2</li>
                <li>Activity 3</li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Our Website. All rights reserved.</p>
    </footer>
</body>
</html>
