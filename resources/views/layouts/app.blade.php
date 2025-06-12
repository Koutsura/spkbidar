<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Website UKM Bina Darma" />
  <meta name="keywords" content="UKM,Universitas Bina Darma,Unit Kegiatan Mahasiswa,website,organisasi" />
  <meta name="author" content="Universitas Bina Darma, M. Denny Tri Lisandi" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('img/tab.webp') }}" type="image/webp" />

  <!-- Styles (with cache busting) -->
  <link href="{{ asset('css/bootstrap.min.css') }}?v={{ filemtime(public_path('css/bootstrap.min.css')) }}" rel="stylesheet" />
  <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet" />
  <link href="{{ asset('css/components.css') }}?v={{ filemtime(public_path('css/components.css')) }}" rel="stylesheet" />
  <link href="{{ asset('css/reverse.css') }}?v={{ filemtime(public_path('css/reverse.css')) }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-dyZ88mC6Up2uqS4h/9G4V3skAbwP6HYIRjLMcE3jmHTfbyWx5XV6fE3VawEc6g0q0Y7jqyV/1G6Up8nFW3r3Ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Title -->
  <title>@yield('title', 'Beranda') &mdash; UKM Universitas Bina Darma</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net" />
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />

  <!-- Scripts (Vite handled) -->
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

  <!-- General JS Scripts (with cache busting) -->
  <script src="{{ asset('js/jquery.min.js') }}?v={{ filemtime(public_path('js/jquery.min.js')) }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}?v={{ filemtime(public_path('js/bootstrap.bundle.min.js')) }}"></script>
  <script src="{{ asset('js/jquery.nicescroll.min.js') }}?v={{ filemtime(public_path('js/jquery.nicescroll.min.js')) }}"></script>
  <script src="{{ asset('js/moment.min.js') }}?v={{ filemtime(public_path('js/moment.min.js')) }}"></script>
  <script src="{{ asset('js/stisla.js') }}?v={{ filemtime(public_path('js/stisla.js')) }}"></script>

  @stack('scripts')

  <!-- Template JS -->
  <script src="{{ asset('js/scripts.js') }}?v={{ filemtime(public_path('js/scripts.js')) }}"></script>
</body>
</html>
