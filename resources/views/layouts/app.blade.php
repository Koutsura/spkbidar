<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Website UKM Bina Darma" />
  <meta name="keywords" content="UKM,Universitas Bina Darma,Unit Kegiatan Mahasiswa,website,organisasi" />
  <meta name="author" content="Universitas Bina Darma, M. Denny Tri Lisandi" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('img/tab.webp') }}" type="img/webp" />

  <!-- Styles -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/components.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/reverse.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>@yield('title', 'Beranda') &mdash; UKM Universitas Bina Darma</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net" />
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />

  <!-- Scripts (Vite) -->
  @vite(['resources/js/app.js'])
</head>
<body>
  <div id="app">
    <div class="main-wrapper">
      <!-- Header -->
      @include('components.header')

      <!-- Sidebar -->
      @include('components.sidebar')

      <!-- Content -->
      @yield('content')

      <!-- Footer -->
      @include('components.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset('js/stisla.js') }}"></script>

  @stack('scripts')

  <!-- Template JS File -->
  <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
