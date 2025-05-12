@auth
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
        <div class="card-header text-center d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('img/logoubd.png') }}" alt="Logo" class="img-fluid" style="width: 150px;">
                    </div>
                </div>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
        <div class="card-header text-center d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid mt-2" style="width: 40px;">
                    </div>
                </div>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="/dashboard"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @if (auth()->user()->role == 'superadmin')
            <li class="menu-header">Hak Akses</li>
            <li class="{{ Request::is('hakakses') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('hakakses') }}"><i class="fas fa-user"></i> <span>Edit Role</span></a>
            </li>
            @endif
            @if (auth()->user()->role == 'rekomendasi' || auth()->user()->role == 'mahasiswa')
             <li class="menu-header">Tes Rekomendasi UKM</li>
             <li class="{{ Request::is('rekomendasi') ? 'active' : '' }}">
                 <a class="nav-link" href="/"><i class="fas fa-newspaper"></i> <span>Rekomendasi UKM</span></a>
             </li>
              @endif
            <li class="menu-header">Profile</li>
            <li class="{{ Request::is('profile/edit') ? 'active' : '' }}">
                <a class="nav-link" href="/"><i class="fas fa-user"></i> <span>Edit Profile</span></a>
            </li>
            @if (auth()->user()->role == 'pendaftaran' || auth()->user()->role == 'superadmin')
            <li class="menu-header">Pages</li>
            <li class="{{ Request::is('pendaftaran') ? 'active' : '' }}">
                <a class="nav-link" href="/"><i class="fas fa-university"></i> <span>Pendaftaran</span></a>
            </li>
             @endif
             @if (auth()->user()->role == 'pelatihan' || auth()->user()->role == 'superadmin')
            <li class="{{ Request::is('pelatihan') ? 'active' : '' }}">
                <a class="nav-link" href="/"><i class="fas fa-university"></i> <span>Pelatihan</span></a>
            </li>
             @endif

             @if (auth()->user()->role == 'pendaftaran' || auth()->user()->role == 'mahasiswa')
             <li class="menu-header">Pages</li>
            <li class="{{ Request::is('pendaftaran') ? 'active' : '' }}">
                <a class="nav-link" href="/"><i class="fas fa-university"></i> <span>Pendaftaran</span></a>
            </li>
             @endif
             @if (auth()->user()->role == 'pelatihan' || auth()->user()->role == 'mahasiswa')
            <li class="{{ Request::is('pelatihan') ? 'active' : '' }}">
                <a class="nav-link" href="/"><i class="fas fa-university"></i> <span>Pelatihan</span></a>
            </li>
             @endif



        </ul>
    </aside>
</div>
@endauth
