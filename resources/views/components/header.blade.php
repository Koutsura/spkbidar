<style>
  /* Hapus custom CSS, biarkan Bootstrap yang mengatur */
</style>

<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <ul class="navbar-nav">
        <li>
            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ms-auto"><!-- ini untuk dropdown user di kanan -->
        @auth
        <li class="nav-item dropdown">
            <a href="#" id="navbarDropdown" role="button"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user"
               data-bs-toggle="dropdown" aria-expanded="false">
                <img alt="image"
                     src="{{ auth()->user()->setting && auth()->user()->setting->profile_photo
                            ? asset('storage/' . auth()->user()->setting->profile_photo)
                            : asset('img/profile.webp') }}"
                     class="rounded-circle me-1"
                     style="width: 35px; height: 35px; object-fit: cover;">
                <div class="d-sm-none d-lg-inline-block">
                    Hai, {{ auth()->check() ? substr(auth()->user()->name, 0, 10) : 'Tamu' }}
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><h6 class="dropdown-header">Selamat Datang, {{ substr(auth()->user()->name, 0, 10) }}</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                     onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logout-form').submit();">
                      <i class="fas fa-sign-out-alt"></i> Logout
                  </a>
                </li>
            </ul>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        @endauth
    </ul>
</nav>

