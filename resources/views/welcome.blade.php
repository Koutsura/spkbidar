<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Website UKM Bina Darma" />
  <meta name="keywords" content="UKM,Universitas Bina Darma,Unit Kegiatan Mahasiswa,website,organisasi" />
  <meta name="author" content="Universitas Bina Darma, M. Denny Tri Lisandi" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />
  <title>Organisasi Unit Kegiatan Mahasiswa Universitas Bina Darma</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('img/tab.webp') }}" type="img/webp" />
  <!-- Bootstrap CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/hawal.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
  <div class="container text-center">
    <!-- Logo Area -->
    <div class="logo-header mb-4">
      <img src="{{ asset('img/logoubd.webp') }}" alt="Universitas Bina Darma Logo" class="img-fluid" />
      <img src="{{ asset('img/mbkm.webp') }}" alt="MBKM Logo" class="img-fluid" />
    </div>

    <!-- Hero Section -->
    <div class="hero">
      <h1 class="display-5 fw-bold">Selamat Datang di Website Organisasi Unit Kegiatan Mahasiswa</h1>
      <p class="lead mb-4">Platform Rekomendasi dan Pendaftaran UKM Universitas Bina Darma</p>
      <div>
        <a href="/login" class="btn btn-outline-light btn-custom btn-login me-2">Login</a>
        <a href="/register" class="btn btn-outline-light btn-custom btn-register">Register</a>
      </div>
    </div>

    <!-- Fitur Deskripsi -->
    <div class="container">
  <div class="row text-center mt-5 feature-section">
    <div class="col-sm-4 mb-4">
      <i class="fas fa-paint-brush fa-3x mb-3 text-primary"></i>
      <h3>Kreativitas</h3>
      <p>Temukan UKM yang menyalurkan ide dan karya unikmu.</p>
    </div>
    <div class="col-sm-4 mb-4">
      <i class="fas fa-laptop-code fa-3x mb-3 text-success"></i>
      <h3>Teknologi</h3>
      <p>Dukung bakatmu di bidang digital dan pemrograman.</p>
    </div>
    <div class="col-sm-4 mb-4">
      <i class="fas fa-praying-hands fa-3x mb-3 text-warning"></i>
      <h3>Religi</h3>
      <p>Gabung dengan komunitas yang mendukung nilai spiritual.</p>
    </div>
  </div>
</div>




<!-- Fitur Deskripsi -->
<div class="row text-center mt-5 feature-section">
  <!-- Gambar kanan, Deskripsi kiri -->
  <div class="col-md-12 mb-4 d-flex flex-md-row-reverse align-items-center">
    <div class="border p-3 me-4" style="flex: 1 1 0; max-width: 400px;">
      <img src="{{ asset('img/busunda.webp') }}" alt="Prof. Dr. Sunda Ariana, M.Pd., M.M." class="img-fluid mb-3" style="max-height: 250px; object-fit: cover;">
    </div>
    <div class="ms-4" style="flex: 2 1 0; padding-right: 2rem;">
      <h3>Prof. Dr. Sunda Ariana, M.Pd., M.M.</h3>
      <p style="text-align: justify;">Saya Prof. Dr. Sunda Ariana, M.Pd., M.M. selaku Rektor Universitas Bina Darma menyampaikan ucapan selamat datang kepada seluruh civitas akademika dan menekankan komitmen universitas dalam memberikan pendidikan berkualitas, mengembangkan potensi mahasiswa, dan membangun karakter yang tangguh. Universitas Bina Darma berupaya terus berkembang dan berinovasi untuk menciptakan lingkungan belajar yang inspiratif, mendukung pengembangan soft skills, dan mempersiapkan lulusan yang kompeten secara profesional serta memiliki integritas sosial. Seluruh civitas akademika diundang untuk bersama-sama berkontribusi dalam membangun atmosfer akademik yang dinamis dan harmonis, dengan harapan agar Allah senantiasa memberikan petunjuk dan kesuksesan dalam perjalanan pendidikan universitas.</p>
    </div>
  </div>

  <!-- Gambar kiri, Deskripsi kanan -->
  <div class="col-md-12 mb-4 d-flex flex-md-row align-items-center">
    <div class="border p-3 ms-4" style="flex: 1 1 0; max-width: 400px;">
      <img src="{{ asset('img/buyanti.webp') }}" alt="Dr. Yanti Pasmawati, S.T., M.T." class="img-fluid mb-3" style="max-height: 250px; object-fit: cover;">
    </div>
    <div class="ms-4" style="flex: 2 1 0; padding-left: 2rem;">
      <h3>Dr. Yanti Pasmawati, S.T., M.T.</h3>
      <p style="text-align: justify;">Saya Dr. Yanti Pasmawati, S.T., M.T. selaku Wakil Rektor Bidang Kemahasiswaan, Alumni dan Kerjasama Universitas Bina Darma menyampaikan ucapan selamat datang kepada seluruh civitas akademika dan menekankan komitmen universitas dalam memberikan pendidikan berkualitas, mengembangkan potensi mahasiswa, dan membangun karakter yang tangguh. Universitas Bina Darma berupaya terus berkembang dan berinovasi untuk menciptakan lingkungan belajar yang inspiratif, mendukung pengembangan soft skills, dan mempersiapkan lulusan yang kompeten secara profesional serta memiliki integritas sosial. Seluruh civitas akademika diundang untuk bersama-sama berkontribusi dalam membangun atmosfer akademik yang dinamis dan harmonis, dengan harapan agar Allah senantiasa memberikan petunjuk dan kesuksesan dalam perjalanan pendidikan universitas.</p>
    </div>
  </div>

  <!-- Gambar kanan, Deskripsi kiri -->
  <div class="col-md-12 mb-4 d-flex flex-md-row-reverse align-items-center">
    <div class="border p-3 me-4" style="flex: 1 1 0; max-width: 400px;">
      <img src="{{ asset('img/pakedi.webp') }}" alt="Prof. Dr. Edi Surya Negara, M.Kom." class="img-fluid mb-3" style="max-height: 250px; object-fit: cover;">
    </div>
    <div class="ms-4" style="flex: 2 1 0; padding-right: 2rem;">
      <h3>Prof. Dr. Edi Surya Negara, M.Kom.</h3>
      <p style="text-align: justify;">
      Saya Prof. Dr. Edi Surya Negara, M.Kom. selaku Wakil Rektor Bidang Riset, Teknologi, dan Inovasi Universitas Bina Darma menyampaikan ucapan selamat datang kepada seluruh civitas akademika dan menekankan komitmen universitas dalam memberikan pendidikan berkualitas, mengembangkan potensi mahasiswa, dan membangun karakter yang tangguh. Universitas Bina Darma berupaya terus berkembang dan berinovasi untuk menciptakan lingkungan belajar yang inspiratif, mendukung pengembangan soft skills, dan mempersiapkan lulusan yang kompeten secara profesional serta memiliki integritas sosial. Seluruh civitas akademika diundang untuk bersama-sama berkontribusi dalam membangun atmosfer akademik yang dinamis dan harmonis, dengan harapan agar Allah senantiasa memberikan petunjuk dan kesuksesan dalam perjalanan pendidikan universitas.</p>
    </div>
  </div>

  <!-- Gambar kiri, Deskripsi kanan -->
  <div class="col-md-12 mb-4 d-flex flex-md-row align-items-center">
    <div class="border p-3 ms-4" style="flex: 1 1 0; max-width: 400px;">
      <img src="{{ asset('img/paknovri.webp') }}" alt="Novri Hadinata, S.Kom., M.Kom." class="img-fluid mb-3" style="max-height: 250px; object-fit: cover;">
    </div>
    <div class="ms-4" style="flex: 2 1 0; padding-left: 2rem;">
      <h3>Novri Hadinata, S.Kom., M.Kom.</h3>
      <p style="text-align: justify;">Saya Novri Hadinata, S.Kom., M.Kom. selaku Ketua Bidang Kemahasiswaan Universitas Bina Darma menyampaikan ucapan selamat datang kepada seluruh civitas akademika dan menekankan komitmen universitas dalam memberikan pendidikan berkualitas, mengembangkan potensi mahasiswa, dan membangun karakter yang tangguh. Universitas Bina Darma berupaya terus berkembang dan berinovasi untuk menciptakan lingkungan belajar yang inspiratif, mendukung pengembangan soft skills, dan mempersiapkan lulusan yang kompeten secara profesional serta memiliki integritas sosial. Seluruh civitas akademika diundang untuk bersama-sama berkontribusi dalam membangun atmosfer akademik yang dinamis dan harmonis, dengan harapan agar Allah senantiasa memberikan petunjuk dan kesuksesan dalam perjalanan pendidikan universitas.</p>
    </div>
  </div>
</div>





  </div>
  <div class="kecil-container">
        <div id="kecil" class="kecil">
          <img src="{{ asset('img/sumsel.webp') }}" alt="Sumatera Selatan"/>
          <img src="{{ asset('img/LLDIKTI 2.webp') }}" alt="LLDIKTI 2"/>
          <img src="{{ asset('img/sumselbabel.webp') }}" alt="Bank Sumsel Babel"/>
          <img src="{{ asset('img/Top1a.webp') }}" alt="Top 1 PTS"/>
          <img src="{{ asset('img/Top1b.webp') }}" alt="Top 1 PTS"/>
          <img src="{{ asset('img/Top1c.webp') }}" alt="Top 1 PTS"/>
          <img src="{{ asset('img/Top1PTS.webp') }}" alt="Top 1 PTS"/>
        </div>
        </div>

        <div class="container">
  <div class="row justify-content-center mt-5 feature-section">
    <div class="col-md-10">
      <h3 class="text-center mb-4">
        Organisasi Unit Kegiatan Mahasiswa (UKM) yang ada di Universitas Bina Darma
      </h3>
      <div class="row">
  <div class="col-md-4" style="text-align: justify;">
    <p>1. UKM Bina Darma Cyber Army (BDCA).</p>
    <p>2. UKM LDK ALQORIB.</p>
    <p>3. UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK).</p>
    <p>4. UKM Kesatuan Mahasiswa Hindu Darma Indonesia (KMHDI).</p>
    <p>5. UKM Panjat Tebing.</p>
    <p>6. UKM Mahasiswa Pencinta Alam (MABIDAR).</p>
  </div>

  <div class="col-md-4" style="text-align: justify;">
    <p>7. UKM Bujang Gadis Kampus (BGK).</p>
    <p>8. UKM Panduan Suara Mahasiswa (BDSC).</p>
    <p>9. UKM Binadarma Debat Union (BDCU).</p>
    <p>10. UKM Bina Darma Programmer (BDPRO).</p>
    <p>11. UKM Futsal.</p>
    <p>12. UKM Seni.</p>
    <p>13. UKM BTV.</p>
  </div>

  <div class="col-md-4" style="text-align: justify;">
    <p>14. UKM Pramuka.</p>
    <p>15. UKM Bina Darma Radio (B‑Radio).</p>
    <p>16. UKM EDS South Sumatera English Community (SSEC).</p>
    <p>17. UKM Pencak Silat.</p>
    <p>18. UKM Basket Club.</p>
    <p>19. UKM Data Science.</p>
    <p>20. UKM Multimedia.</p>
  </div>
</div>

    </div>
  </div>
</div>

@include('components.footer')

</div>
  <!-- Bootstrap JS -->
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
