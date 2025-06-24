@extends('layouts.app')

@section('title', 'Edit Data Hak Akses')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Hak Akses</h1>
        </div>
        <form action="{{ route('hakakses.update', $hakakses->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="role">Hak Akses</label>
                <select name="role" id="role" class="form-control">
    <option value="mahasiswa" {{ $hakakses->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
    <option value="superadmin" {{ $hakakses->role == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
    <option value="alqarib" {{ $hakakses->role == 'alqarib' ? 'selected' : '' }}>Alqarib</option>
    <option value="BDCA" {{ $hakakses->role == 'BDCA' ? 'selected' : '' }}>BDCA</option>
    <option value="BDCU" {{ $hakakses->role == 'BDCU' ? 'selected' : '' }}>BDCU</option>
    <option value="BDPRO" {{ $hakakses->role == 'BDPRO' ? 'selected' : '' }}>BDPRO</option>
    <option value="BDSC" {{ $hakakses->role == 'BDSC' ? 'selected' : '' }}>BDSC</option>
    <option value="BGK" {{ $hakakses->role == 'BGK' ? 'selected' : '' }}>BGK</option>
    <option value="BRadio" {{ $hakakses->role == 'BRadio' ? 'selected' : '' }}>BRadio</option>
    <option value="KMHDI" {{ $hakakses->role == 'KMHDI' ? 'selected' : '' }}>KMHDI</option>
    <option value="MABIDAR" {{ $hakakses->role == 'MABIDAR' ? 'selected' : '' }}>MABIDAR</option>
    <option value="Olahraga" {{ $hakakses->role == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
    <option value="PMKK" {{ $hakakses->role == 'PMKK' ? 'selected' : '' }}>PMKK</option>
    <option value="Pramuka" {{ $hakakses->role == 'Pramuka' ? 'selected' : '' }}>Pramuka</option>
    <option value="SSEC" {{ $hakakses->role == 'SSEC' ? 'selected' : '' }}>SSEC</option>
</select>

            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </section>
</div>
@endsection
