<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Website UKM Bina Darma" />
  <meta name="keywords" content="UKM,Universitas Bina Darma,Unit Kegiatan Mahasiswa,website,organisasi" />
  <meta name="author" content="Universitas Bina Darma, M. Denny Tri Lisandi" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
  <title>Register</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('img/tab.webp') }}" type="img/webp" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 2rem;
    }
    .form-section {
      background-color: #fff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-group {
      margin-bottom: 1rem;
    }
    #strengthMessage {
      font-weight: bold;
      margin-top: 0.5rem;
    }
    .progress {
      height: 8px;
      margin-top: 5px;
    }
    .invalid-feedback {
      display: none;
      color: red;
    }
    @media (max-width: 768px) {
      .image-section {
        display: none;
      }
    }
  </style>
</head>
<body>

<div class="container-fluid form-container">
  <div class="row w-100 justify-content-center">
    <!-- Left Image Section -->
    <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
  <img src="{{ asset('img/register.webp') }}" alt="Registration Illustration" class="img-fluid w-75">
</div>


    <!-- Right Form Section -->
    <div class="col-lg-5 col-md-6 form-section">
      <a href="/" class="btn btn-outline-secondary mb-3">&larr; Kembali</a>
      <h2 class="text-primary">Daftar Akun</h2>
      <p>Isi formulir berikut untuk membuat akun baru.</p>

      <form id="registerForm" method="POST" action="/register">
    @csrf
<div class="form-group">
          <label for="name">Nama</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
        </div>
        <div class="form-group">
          <label for="password">Kata Sandi</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata sandi" required onkeyup="checkPasswordStrength()">
          <div class="progress">
            <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
          </div>
          <small id="strengthMessage" class="form-text mt-1"></small>
          <div class="invalid-feedback" id="passwordError">Password harus minimal 5 karakter, mengandung huruf besar, dan karakter spesial.</div>
        </div>
        <div class="form-group">
          <label for="confirmPassword">Konfirmasi Kata Sandi</label>
          <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" placeholder="Ulangi kata sandi" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Daftar</button>
        <div class="text-center">
        <a href="/forgot-password" class="d-block mb-2">Lupa Kata sandi?</a>
        <p class="mb-0">Sudah punya Akun?
        <a href="/login" class="text-primary">Masuk sekarang</a>
        </p>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function checkPasswordStrength() {
    const password = document.getElementById("password").value;
    const strengthBar = document.getElementById("strengthBar");
    const message = document.getElementById("strengthMessage");
    const error = document.getElementById("passwordError");

    const hasUpperCase = /[A-Z]/.test(password);
    const hasSpecialChar = /[\W_]/.test(password);
    const isLongEnough = password.length >= 5;

    let strength = 0;
    if (isLongEnough) strength += 1;
    if (hasUpperCase) strength += 1;
    if (hasSpecialChar) strength += 1;

    if (!password) {
      strengthBar.style.width = "0%";
      strengthBar.className = "progress-bar";
      message.textContent = "";
      error.style.display = "none";
      return;
    }

    switch (strength) {
      case 1:
        strengthBar.style.width = "33%";
        strengthBar.className = "progress-bar bg-danger";
        message.textContent = "Lemah";
        message.style.color = "red";
        error.style.display = "block";
        break;
      case 2:
        strengthBar.style.width = "66%";
        strengthBar.className = "progress-bar bg-warning";
        message.textContent = "Sedang";
        message.style.color = "orange";
        error.style.display = "block";
        break;
      case 3:
        strengthBar.style.width = "100%";
        strengthBar.className = "progress-bar bg-success";
        message.textContent = "Kuat";
        message.style.color = "green";
        error.style.display = "none";
        break;
    }
  }

  document.getElementById("registerForm").addEventListener("submit", function(e) {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const error = document.getElementById("passwordError");

    const hasUpperCase = /[A-Z]/.test(password);
    const hasSpecialChar = /[\W_]/.test(password);
    const isLongEnough = password.length >= 5;

    if (!hasUpperCase || !hasSpecialChar || !isLongEnough) {
      e.preventDefault();
      error.style.display = "block";
      document.getElementById("password").focus();
      return false;
    }

    if (password !== confirmPassword) {
      e.preventDefault();
      alert("Konfirmasi kata sandi tidak cocok.");
      return false;
    }
  });
</script>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
