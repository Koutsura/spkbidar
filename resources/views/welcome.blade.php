<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Website UKM Bina Darma" />
  <meta name="keywords" content="UKM, Universitas Bina Darma, Unit Kegiatan Mahasiswa, website, organisasi" />
  <meta name="author" content="Universitas Bina Darma, M. Denny Tri Lisandi" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />
  <title>Organisasi Unit Kegiatan Mahasiswa Universitas Bina Darma</title>

  <link rel="icon" href="{{ asset('img/tab.webp') }}" type="image/webp" />
  <link href="{{ asset('css/bootstrap.min.css') }}?v={{ time() }}" rel="stylesheet" />
<link href="{{ asset('css/hawal.css') }}?v={{ time() }}" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
<div class="container text-center">

  <div class="logo-header mb-4 scroll-animate">
  <img src="{{ asset('img/logoubd.webp') }}" alt="Universitas Bina Darma Logo" class="img-fluid" />
  <img src="{{ asset('img/mbkm.webp') }}" alt="MBKM Logo" class="img-fluid" />
</div>

<div class="hero-section text-center px-3 py-5 scroll-animate">
  <h1>
  Selamat Datang di<br>
  Website Organisasi UKM<br>
  Universitas Bina Darma
</h1>
  <p>
    Platform Tes Rekomendasi dan Pendaftaran UKM Universitas Bina Darma.
  </p>
</div>
<div class="mt-5 scroll-animate">
  <h2 class="fw-bold mb-4" style="font-size: 2rem;">Daftar Organisasi Unit Kegiatan Mahasiswa (UKM) di Universitas Bina Darma</h2>
  <ul class="list-group list-group-flush text-start mx-auto" style="max-width: 700px; font-size: 1.2rem;">
    <li class="list-group-item">1. UKM Bina Darma Cyber Army (BDCA)</li>
    <li class="list-group-item">2. UKM LDK ALQORIB</li>
    <li class="list-group-item">3. UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK)</li>
    <li class="list-group-item">4. UKM Kesatuan Mahasiswa Hindu Dharma Indonesia (KMHDI)</li>
    <li class="list-group-item">5. UKM Mahasiswa Pencinta Alam (MABIDAR)</li>
    <li class="list-group-item">6. UKM Bujang Gadis Kampus (BGK)</li>
    <li class="list-group-item">7. UKM Panduan Suara Mahasiswa (BDSC)</li>
    <li class="list-group-item">8. UKM Binadarma Debat Union (BDCU)</li>
    <li class="list-group-item">9. UKM Bina Darma Programmer (BDPRO)</li>
    <li class="list-group-item">10. UKM Olahraga</li>
    <li class="list-group-item">11. UKM Pramuka</li>
    <li class="list-group-item">12. UKM Bina Darma Radio (B-Radio)</li>
    <li class="list-group-item">13. UKM EDS South Sumatera English Community (SSEC)</li>
  </ul>
</div>

<div class="mt-5 scroll-animate">
  <h2 class="fw-bold mb-4 text-center" style="font-size: 2rem;">Ayo Tingkatkan Skill-mu dan Raih Prestasi!</h2>
  <p class="text-center mb-4" style="font-size: 1.2rem; color: #555;">
    Seperti mereka yang sudah membuktikan bahwa aktif di UKM bisa membawamu hingga ke podium juara.
  </p>

  <div class="row justify-content-center g-4">
    <!-- Card 1 -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="{{ asset('img/juara1.webp') }}" class="card-img-top img-fixed" alt="Pemenang 1">
        <div class="card-body">
          <h5 class="card-title">Juara 3 Lomba Hackthon Fordigi BUMN 2023</h5>
          <p class="card-text">Universitas Bina Darma Raih Juara 3 Lomba Hackthon Fordigi BUMN 2023 Persembahkan Solusi Inovatif Dengan Aplikasi PIONS.</p>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="{{ asset('img/juara2.webp') }}" class="card-img-top img-fixed" alt="Pemenang 2">
        <div class="card-body">
          <h5 class="card-title">Universitas Bina Darma Palembang Juara 2 Lomba Tahfidz Islamic Cempetition Series II</h5>
          <p class="card-text"> Mahasiswa Fakultas Sosial Humaniora Program Studi (Prodi) Psikologi Universitas Bina Darma (UBD) Palembang, Marisa Anggraeni berhasil menuai prestasi kala Ramadhan 1444 Hijriah..</p>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="{{ asset('img/juara3.webp') }}" class="card-img-top img-fixed" alt="Pemenang 3">
        <div class="card-body">
          <h5 class="card-title">Tim Futsal UBD Gondol Juara 3 Turnamen Dekan Cup Unsri 7.0 2023</h5>
          <p class="card-text">Tim futsal Bina Darma meraih juara 3 pada turnamen futsal Dekan Cup Unsri 7.0 2023 yang mengangkat tema "Rise Up The Spirit of Competition".</p>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container mt-5 scroll-animate">
  <h2 class="text-center mb-4">Statistik UKM per Tahun Angkatan</h2>

  @if (!empty($years))
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="text-center">Mahasiswa yang sudah Tes Rekomendasi UKM</h5>
            <canvas id="chartTes"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="text-center">Mahasiswa yang sudah daftar UKM</h5>
            <canvas id="chartPendaftaran"></canvas>
          </div>
        </div>
      </div>
    </div>

    <script>
      const years = {!! json_encode($years) !!};
      const dataTes = {!! json_encode($userChartData) !!};
      const dataDaftar = {!! json_encode($pendaftarChartData) !!};

      new Chart(document.getElementById('chartTes').getContext('2d'), {
        type: 'bar',
        data: {
          labels: years,
          datasets: [{
            label: 'Jumlah Tes',
            data: dataTes,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              ticks: { stepSize: 1 },
              title: { display: true, text: 'Jumlah' }
            },
            x: {
              title: { display: true, text: 'Tahun Angkatan' }
            }
          }
        }
      });

      new Chart(document.getElementById('chartPendaftaran').getContext('2d'), {
        type: 'bar',
        data: {
          labels: years,
          datasets: [{
            label: 'Jumlah Pendaftar',
            data: dataDaftar,
            backgroundColor: 'rgba(255, 99, 132, 0.7)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              ticks: { stepSize: 1 },
              title: { display: true, text: 'Jumlah' }
            },
            x: {
              title: { display: true, text: 'Tahun Angkatan' }
            }
          }
        }
      });
    </script>
  @else
    <div class="alert alert-info text-center">
      Belum ada data user.
    </div>
  @endif
</div>

</div>
<!-- Section: Ketua Bidang Kemahasiswaan -->
<div class="container my-5 scroll-animate">
  <div class="row align-items-center">
    <!-- Gambar -->
    <div class="col-md-4 text-center mb-4 mb-md-0">
      <img src="{{ asset('img/paknovri.webp') }}" alt="Novri Hadinata, S.Kom., M.Kom."
           class="img-fluid rounded shadow" style="max-height: 300px; object-fit: cover;">
    </div>

    <!-- Deskripsi -->
    <div class="col-md-8 d-flex align-items-center">
      <div class="w-100">
        <!-- Nama dan jabatan -->
        <div class="mb-4 border-bottom pb-2">
          <h3 class="fw-bold mb-1">Novri Hadinata, S.Kom., M.Kom.</h3>
          <h5 class="text-muted mb-0">(Ketua Bidang Kemahasiswaan Universitas Bina Darma)</h5>
        </div>

        <!-- Box ajakan -->
        <div class="bg-light p-4 rounded shadow-sm">
          <h4 class="fw-bold mb-3">Bingung mau masuk UKM mana?</h4>
          <p class="mb-3">Ayo Tes Rekomendasi UKM sekarang juga dan temukan organisasi yang paling sesuai dengan minat dan potensimu!</p>
          <a href="/login" class="btn btn-primary px-4 py-2">Get Started</a>
        </div>
      </div>
    </div>
  </div>
</div>

@include('components.footer')

<script src="{{ asset('js/bootstrap.bundle.min.js') }}?v={{ time() }}"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("active");
          observer.unobserve(entry.target); // animasi hanya sekali
        }
      });
    }, {
      threshold: 0.1
    });

    document.querySelectorAll(".scroll-animate").forEach(el => observer.observe(el));
  });
</script>


</body>
</html>
