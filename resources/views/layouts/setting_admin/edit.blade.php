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

                        <div class="mb-3">
                            <label for="organization_1" class="form-label">Organisasi 1</label>
                            <input type="text" id="organization_1" name="organization_1"
                                   class="form-control @error('organization_1') is-invalid @enderror"
                                   value="{{ old('organization_1', $setting->organization_1 ?? '') }}">
                            @error('organization_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="organization_2" class="form-label">Organisasi 2</label>
                            <input type="text" id="organization_2" name="organization_2"
                                   class="form-control @error('organization_2') is-invalid @enderror"
                                   value="{{ old('organization_2', $setting->organization_2 ?? '') }}">
                            @error('organization_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="organization_3" class="form-label">Organisasi 3</label>
                            <input type="text" id="organization_3" name="organization_3"
                                   class="form-control @error('organization_3') is-invalid @enderror"
                                   value="{{ old('organization_3', $setting->organization_3 ?? '') }}">
                            @error('organization_3')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Organisasi</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
