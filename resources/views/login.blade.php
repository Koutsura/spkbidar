<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
  <meta name="description" content="Website UKM Bina Darma" />
  <meta name="keywords" content="UKM,Universitas Bina Darma,Unit Kegiatan Mahasiswa,website,organisasi" />
  <meta name="author" content="Universitas Bina Darma, M. Denny Tri Lisandi" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Login</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .login-image {
            max-height: 80vh;
            width: 100%;
            object-fit: contain;
        }
        @media (max-width: 767.98px) {
            .login-container {
                padding: 2rem 1rem;
            }
            .login-image {
                margin-top: 2rem;
                max-height: 40vh;
            }
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="row w-100 align-items-center">
            <!-- Form section -->
            <div class="col-lg-6">
                <div class="login-card">
                <a href="/" class="btn btn-outline-secondary mb-3">
        &larr; Kembali
    </a>
                    <h2 class="text-primary">Silakan Login terlebih dahulu</h2>
                    <p>Masukkan Email dan Kata Sandi mu untuk masuk ke akun.</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   required value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="password"
                                   name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>

                        <div class="text-center">
                            <a href="/forgot-password" class="d-block mb-2">Lupa Kata sandi?</a>
                            <p class="mb-0">Belum punya Akun?
                                <a href="/register" class="text-primary">Buat akun sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Image section -->
            <div class="col-lg-6 text-center d-none d-lg-flex justify-content-center">
                <img src="{{ asset('img/login.jpg') }}" alt="Login Illustration" class="img-fluid login-image">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
