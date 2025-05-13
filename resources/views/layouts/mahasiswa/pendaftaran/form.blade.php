@extends('layouts.app')

@section('title', 'Form Pendaftaran Organisasi')

@push('style')
    <style>
        .form-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
<div class="container mt-5">
    <div class="form-section">
        <h4 class="mb-4">Formulir Pendaftaran Organisasi</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.pendaftaran.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Informasi dari Users dan Settings --}}
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" readonly class="form-control" value="{{ $user->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">NIM</label>
                <input type="text" readonly class="form-control" value="{{ $setting->nim }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jurusan</label>
                <input type="text" readonly class="form-control" value="{{ $setting->jurusan }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" readonly class="form-control" value="{{ $setting->phone_number }}">
            </div>

            {{-- Organisasi --}}
            <div class="mb-3">
                <label class="form-label">Organisasi 1</label>
                <input type="text" name="organization_1" class="form-control" value="{{ old('organization_1', $setting->organization_1) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Organisasi 2</label>
                <input type="text" name="organization_2" class="form-control" value="{{ old('organization_2', $setting->organization_2) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Organisasi 3</label>
                <input type="text" name="organization_3" class="form-control" value="{{ old('organization_3', $setting->organization_3) }}">
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label class="form-label">Deskripsi Diri</label>
                <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
            </div>

            {{-- Upload File --}}
            <div class="mb-3">
                <label class="form-label">Upload Berkas (PDF, JPG, PNG)</label>
                <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
        </form>
    </div>
</div>
@endsection
