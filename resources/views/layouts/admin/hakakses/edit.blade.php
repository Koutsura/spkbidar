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
                    <option value="superadmin" {{ $hakakses->role == 'superadmin' ? 'selected' : '' }}>superadmin</option>
                </select>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </section>
</div>
@endsection
