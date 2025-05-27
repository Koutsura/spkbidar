@auth
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
        <div class="card-header text-center d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('img/logoubd.webp') }}" alt="Logo" class="img-fluid" style="width: 150px;">
                    </div>
                </div>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
        <div class="card-header text-center d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('img/logo.webp') }}" alt="Logo" class="img-fluid mt-2" style="width: 40px;">
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

    @php
        $sudahTes = \App\Models\Result::where('user_id', auth()->id())->exists();
        $link = $sudahTes ? route('spk.result') : route('spk.index');
    @endphp

    <li class="{{ Request::is('rekomendasi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ $link }}">
            <i class="fas fa-newspaper"></i>
            <span>{{ $sudahTes ? 'Lihat Hasil Rekomendasi' : 'Rekomendasi UKM' }}</span>
        </a>
    </li>
@endif

              @if (auth()->user()->role == 'rekomendasi' || auth()->user()->role == 'mahasiswa')
            <li class="menu-header">Edit Profile</li>
            <li class="{{ Request::is('profile') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('settings.index') }}"><i class="fas fa-user"></i> <span>Edit Profile</span></a>
            </li>
            @endif
           @if (auth()->user()->role === 'rekomendasi' || auth()->user()->role === 'superadmin')
           <li class="menu-header">Edit Profile Mahasiswa</li>
    <li class="{{ request()->routeIs('setting_admin.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('setting_admin.index', ['user' => auth()->user()->id]) }}">
            <i class="fas fa-user"></i>
            <span>Edit Organisasi mahasiswa</span>
        </a>
    </li>
@endif



            @if (auth()->user()->role == 'pendaftaran' || auth()->user()->role == 'superadmin')
            <li class="menu-header">Pages</li>
            <li class="{{ Request::is('pendaftaran') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pendaftaran.index') }}"><i class="fas fa-university"></i> <span>Pendaftaran</span></a>
            </li>
             @endif
             @if (auth()->user()->role == 'pelatihan' || auth()->user()->role == 'superadmin')
    <li class="{{ Request::is('pelatihan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pelatihan.index') }}"><i class="fas fa-university"></i> <span>Pelatihan</span></a>
    </li>
@endif


            @if (auth()->user()->role == 'pendaftaran' || auth()->user()->role == 'mahasiswa')
    <li class="menu-header">Pages</li>
    <li class="{{ Request::routeIs('mahasiswa.pendaftaran.form') ? 'active' : '' }}">
        @if ($sudahTes)
            <a class="nav-link" href="{{ route('mahasiswa.pendaftaran.form') }}">
                <i class="fas fa-university"></i> <span>Pendaftaran</span>
            </a>
        @else
            <a class="nav-link disabled text-muted" href="#" onclick="return false;">
                <i class="fas fa-university"></i> <span>Pendaftaran (Terkunci)</span>
            </a>
        @endif
    </li>
@endif

@if (auth()->user()->role == 'pelatihan' || auth()->user()->role == 'mahasiswa')
    <li class="{{ Request::is('pelatihan') ? 'active' : '' }}">
        @if ($sudahTes)
            <a class="nav-link" href="{{ route('mahasiswa.pelatihan.index') }}">
                <i class="fas fa-university"></i> <span>Pelatihan</span>
            </a>
        @else
            <a class="nav-link disabled text-muted" href="#" onclick="return false;">
                <i class="fas fa-university"></i> <span>Pelatihan (Terkunci)</span>
            </a>
        @endif
    </li>
@endif




        </ul>
    </aside>
</div>
@endauth
