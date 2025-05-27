@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- input lainnya seperti NIM, jurusan, dsb -->

    <div class="mb-3">
        <label for="profile_photo" class="form-label">Foto Profil</label>
        <input type="file" class="form-control" name="profile_photo" id="profile_photo" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

</div>
@endsection
