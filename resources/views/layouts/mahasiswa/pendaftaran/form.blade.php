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
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Formulir Pendaftaran Organisasi</h1>
        </div>

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
                <label class="form-label">Tahun Angkatan</label>
                <input type="text" readonly class="form-control" value="{{ $setting->tahun_angkatan }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" readonly class="form-control" value="{{ $setting->phone_number }}">
            </div>

            @php
                $ukms = [
                    'UKM Bina Darma Cyber Army (BDCA)',
                    'UKM LDK ALQORIB',
                    'UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK)',
                    'UKM Kesatuan Mahasiswa Hindu Darma Indonesia (KMHDI)',
                    'UKM Mahasiswa Pencinta Alam (MABIDAR)',
                    'UKM Bujang Gadis Kampus (BGK)',
                    'UKM Panduan Suara Mahasiswa (BDSC)',
                    'UKM Binadarma Debat Union (BDCU)',
                    'UKM Bina Darma Programmer (BDPRO)',
                    'UKM Olahraga',
                    'UKM Pramuka',
                    'UKM Bina Darma Radio (B-Radio)',
                    'UKM EDS South Sumatera English Community (SSEC)',
                ];
            @endphp

            {{-- Organisasi 1 --}}
<div class="mb-3">
    <label class="form-label">Organisasi 1</label>
    <select name="organization_1" class="form-select" id="organization_1"
        {{ $setting->organization_1 ? 'disabled' : 'required' }}>
        <option value="">-- Pilih Organisasi 1 --</option>
        @foreach($ukms as $ukm)
            <option value="{{ $ukm }}" {{ old('organization_1', $setting->organization_1) == $ukm ? 'selected' : '' }}>{{ $ukm }}</option>
        @endforeach
    </select>
    @if($setting->organization_1)
        <input type="hidden" name="organization_1" value="{{ $setting->organization_1 }}">
    @endif
</div>

{{-- Organisasi 2 --}}
<div class="mb-3">
    <label class="form-label">Organisasi 2</label>
    <select name="organization_2" class="form-select" id="organization_2"
        {{ !$setting->organization_1 || $setting->organization_2 ? 'disabled' : '' }}>
        <option value="">-- Pilih Organisasi 2 --</option>
        @foreach($ukms as $ukm)
            <option value="{{ $ukm }}" {{ old('organization_2', $setting->organization_2) == $ukm ? 'selected' : '' }}>{{ $ukm }}</option>
        @endforeach
    </select>
    @if($setting->organization_2)
        <input type="hidden" name="organization_2" value="{{ $setting->organization_2 }}">
    @endif
</div>

{{-- Organisasi 3 --}}
<div class="mb-3">
    <label class="form-label">Organisasi 3</label>
    <select name="organization_3" class="form-select" id="organization_3"
        {{ !$setting->organization_2 || $setting->organization_3 ? 'disabled' : '' }}>
        <option value="">-- Pilih Organisasi 3 --</option>
        @foreach($ukms as $ukm)
            <option value="{{ $ukm }}" {{ old('organization_3', $setting->organization_3) == $ukm ? 'selected' : '' }}>{{ $ukm }}</option>
        @endforeach
    </select>
    @if($setting->organization_3)
        <input type="hidden" name="organization_3" value="{{ $setting->organization_3 }}">
    @endif
</div>



            {{-- Alamat --}}
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $pendaftaran->alamat ?? '') }}</textarea>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label class="form-label">Deskripsi Diri</label>
                <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $pendaftaran->deskripsi ?? '') }}</textarea>
            </div>

            {{-- Upload File --}}
            <div class="mb-3">
                <label class="form-label">Upload Berkas (PDF, JPG, PNG)</label>
                <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Maksimal ukuran file : 20MB</small><br>
                @if(isset($pendaftaran) && $pendaftaran->file)
                    <small class="text-muted">File sebelumnya: {{ basename($pendaftaran->file) }}</small>
                @endif
            </div>

            <div class="text-end mt-4 mb-5">
    <button type="submit" class="btn btn-primary" id="btn-submit" value="1">Kirim Pendaftaran</button>
</div>

        </form>
    </section>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33'
        });
    @endif

    document.addEventListener('DOMContentLoaded', function () {
        const org1 = document.getElementById('organization_1');
        const org2 = document.getElementById('organization_2');
        const org3 = document.getElementById('organization_3');
        const btnSubmit = document.getElementById('btn-submit');

        // Aktifkan organization 2 jika organization 1 terisi
        if (org1 && org1.value !== "") {
            org2.disabled = false;
            org3.disabled = true;
        }

        // Aktifkan organization 3 jika organization 2 terisi
        if (org2 && org2.value !== "") {
            org2.disabled = true;
            org3.disabled = false;
        }
        // Jika semuanya terisi → kunci semua
        if (org1.value && org2.value && org3.value && btnSubmit.value) {
            org1.disabled = true;
            org2.disabled = true;
            org3.disabled = true;
            btnSubmit.disabled = true;
            return;
        }


        // Tambahkan event listener untuk organisasi 2
        org2?.addEventListener('change', function () {
            if (this.value !== "") {
                org3.disabled = true;
            } else {
                org3.value = "";
                org3.disabled = true;
            }
        });



    });
</script>
@endpush
