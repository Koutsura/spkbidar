@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Profil Saya</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Foto Profil -->
                <div class="text-center mb-4">
                    @if($setting && $setting->profile_photo)
                        <img src="{{ asset('storage/' . $setting->profile_photo) }}" class="rounded-circle" width="120" height="120" style="object-fit: cover;">
                        @dump(asset('storage/' . $setting->profile_photo))
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=fff&size=120" class="rounded-circle" width="120" height="120">
                    @endif
                    <h4 class="mt-3">{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                </div>

                <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="profile_photo" class="form-label">Ganti Foto Profil</label>
                        <input type="file" class="form-control" name="profile_photo" id="profile_photo" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" name="nim" id="nim" value="{{ old('nim', $setting->nim ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ old('phone_number', $setting->phone_number ?? '') }}">
                    </div>

                    <div class="mb-3">
    <label for="jurusan" class="form-label">Jurusan</label>
    <select class="form-control" name="jurusan" id="jurusan">
        @php
            $jurusanOptions = [
                'Sistem Informasi',
                'Teknik Informatika',
                'Manajemen',
                'Akuntansi',
                'Teknik Sipil',
                'Teknik Elektro',
                'Teknik Industri',
                'Psikologi',
                'Ilmu Komunikasi',
                'Pendidikan Bahasa Indonesia',
                'Pendidikan Olahraga',
                'Sastra Inggris',
                'Manajemen Informatika',
                'Pengelolaan Perhotelan',
                'Administrasi Bisnis',
                'Teknik Komputer',
            ];
            $selectedJurusan = old('jurusan', $setting->jurusan ?? '');
        @endphp

        <option value="">-- Pilih Jurusan --</option>
        @foreach($jurusanOptions as $jurusan)
            <option value="{{ $jurusan }}" {{ $jurusan == $selectedJurusan ? 'selected' : '' }}>
                {{ $jurusan }}
            </option>
        @endforeach
    </select>
</div>


                    <div class="mb-3">
                        <label class="form-label">Organisasi Direkomendasikan</label>
                        <ul class="list-group">
                            <li class="list-group-item">Organisasi 1: {{ $setting->organization_1 ?? 'Belum diatur' }}</li>
                            <li class="list-group-item">Organisasi 2: {{ $setting->organization_2 ?? 'Belum diatur' }}</li>
                            <li class="list-group-item">Organisasi 3: {{ $setting->organization_3 ?? 'Belum diatur' }}</li>
                        </ul>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan Profil</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>
@endsection
