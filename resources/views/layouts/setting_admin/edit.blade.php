@extends('layouts.app')

@section('title', 'Edit Organisasi UKM Mahasiswa')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Organisasi UKM Mahasiswa</h1>
        </div>

        <div class="section-body">
            <form action="{{ route('setting_admin.update', $user->id) }}" method="POST">
                @csrf
                @method('POST')

                <div class="card">
                    <div class="card-body">
                        <h5>Nama: {{ $user->name }}</h5>
                        <p>Email: {{ $user->email }}</p>

                        @php
    $ukmOptions = [
        'UKM Bina Darma Cyber Army (BDCA)',
        'UKM LDK ALQORIB',
        'UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK)',
        'UKM Kesatuan Mahasiswa Hindu Darma Indonesia (KMHDI)',
        'UKM Panjat Tebing',
        'UKM Mahasiswa Pencinta Alam (MABIDAR)',
        'UKM Bujang Gadis Kampus (BGK)',
        'UKM Panduan Suara Mahasiswa (BDSC)',
        'UKM Binadarma Debat Union (BDCU)',
        'UKM Bina Darma Programmer (BDPRO)',
        'UKM Futsal',
        'UKM Seni',
        'UKM Pramuka',
        'UKM Bina Darma Radio (B-Radio)',
        'UKM EDS South Sumatera English Community (SSEC)',
        'Inovator Center (DIIB)',
        'UKM Pencak Silat',
        'UKM Basket Club',
    ];
@endphp

@for($i = 1; $i <= 3; $i++)
    @php $fieldName = "organization_$i"; @endphp
    <div class="mb-3">
        <label for="{{ $fieldName }}" class="form-label">Organisasi {{ $i }}</label>
        <select id="{{ $fieldName }}" name="{{ $fieldName }}"
                class="form-control @error($fieldName) is-invalid @enderror">
            <option value="">-- Pilih Organisasi --</option>
            @foreach ($ukmOptions as $option)
                <option value="{{ $option }}"
                    {{ old($fieldName, $setting->$fieldName ?? '') == $option ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
        @error($fieldName)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endfor


                        <button type="submit" class="btn btn-primary">Simpan Organisasi</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
