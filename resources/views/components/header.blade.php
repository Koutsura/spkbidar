<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <ul class="navbar-nav ml-auto">
        @auth
        <li>
            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
    <a href="#" id="navbarDropdown" role="button"
       class="nav-link dropdown-toggle nav-link-lg nav-link-user"
       data-bs-toggle="dropdown" aria-expanded="false">
        <img alt="image" src="{{ asset('img/profile.png') }}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">
            Hai, {{ auth()->check() ? substr(auth()->user()->name, 0, 10) : 'Tamu' }}
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <div class="dropdown-title">
            Selamat Datang, {{ auth()->check() ? substr(auth()->user()->name, 0, 10) : 'Tamu' }}
        </div>
        <a class="dropdown-item has-icon edit-profile" href="/" data-id="{{ \Auth::id() }}">
            <i class="fa fa-user"></i> Edit Profile
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
           onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</li>

        @endauth
    </ul>
</nav>
