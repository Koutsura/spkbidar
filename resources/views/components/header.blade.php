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

    <ul class="navbar-nav ms-auto">
        {{-- Notifikasi --}}
        @if ( auth()->user()->role == 'mahasiswa')
      @auth
<li class="nav-item dropdown">
    <a href="#"
       class="nav-link nav-link-lg position-relative"
       data-bs-toggle="dropdown"
       aria-expanded="false"
       id="notifDropdownToggle"
       style="padding: 0.375rem 0.5rem;">
        <i class="far fa-bell" style="font-size: 1.1rem;"></i>
        <span id="notifBadge"
              class="badge bg-danger position-absolute top-0 start-100 translate-middle badge-sm rounded-circle"
              style="font-size: 0.65rem; min-width: 16px; height: 16px; display: none;">
        </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" style="max-width: 280px; width: 100%;">
        <li><h6 class="dropdown-header py-2 px-3" style="font-size: 0.9rem;">Notifikasi</h6></li>
        <li><hr class="dropdown-divider my-1"></li>

        @forelse($notifications as $notification)
            <li>
                <a href="#"
                   class="dropdown-item d-flex align-items-start flex-wrap py-2 px-3"
                   style="font-size: 0.85rem;"
                   data-notif-id="{{ $notification->id }}">
                    <i class="fas fa-info-circle text-primary me-2 flex-shrink-0" style="margin-top: 3px; font-size: 0.9rem;"></i>
                    <div class="flex-grow-1" style="word-break: break-word; white-space: normal; overflow-wrap: anywhere;">
                        <div class="small text-muted" style="font-size: 0.7rem;">{{ $notification->created_at->diffForHumans() }}</div>
                        <div>{{ $notification->message }}</div>
                    </div>
                </a>
            </li>
        @empty
            <li class="dropdown-item text-center text-muted" style="font-size: 0.85rem;">Tidak ada notifikasi</li>
        @endforelse

        <li><hr class="dropdown-divider my-1"></li>
        <li>
            <a href="#"
               id="clearNotifications"
               class="dropdown-item text-center py-2"
               style="font-size: 0.85rem; cursor:pointer;">
                Lihat semua notifikasi
            </a>
        </li>
    </ul>
</li>
@endauth
@endif
        {{-- User Dropdown --}}
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
                <li><h6 class="dropdown-header">{{ substr(auth()->user()->name, 0, 10) }}</h6></li>
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

   <script src="{{ asset('js/notifikasi.js') }}"></script>
