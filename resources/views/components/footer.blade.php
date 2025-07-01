<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<footer class="footer bg-dark text-white pt-4">
  <div class="container">
    <div class="row">

      <!-- Tombol Kembali ke Atas -->
      <div class="text-center mb-3 w-100">
        <button onclick="scrollToTop()"
                class="btn btn-primary rounded-circle shadow"
                style="width: 60px; height: 60px; font-size: 24px;">
          <i class="bi bi-arrow-up"></i>
        </button>
      </div>

      <!-- Copyright -->
      <div class="text-center p-3 border-top border-secondary w-100">
        © 2025 <a href="https://binadarma.ac.id" class="text-white text-decoration-none">Universitas Bina Darma</a>. All rights reserved.
      </div>

    </div>
  </div>

  <script>
    function scrollToTop() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }
  </script>
</footer>
