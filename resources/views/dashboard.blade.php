<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Logged In</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        header { background: #333; color: #fff; padding: 1rem; }
        header h1 { margin: 0; }
        nav ul { list-style: none; padding: 0; display: flex; gap: 1rem; }
        nav ul li { display: inline; }
        nav ul li a, nav form button { color: #fff; text-decoration: none; background: none; border: none; cursor: pointer; }
        main { padding: 2rem; background: #fff; margin: 2rem; border-radius: 8px; }
        footer { text-align: center; padding: 1rem; background: #eee; }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, {{ Auth::user()->name }}</h1>
        <nav>
            <ul>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Settings</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
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
