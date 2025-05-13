@extends('layouts.app')

@section('title', 'Manajemen Pendaftaran')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Pendaftaran Mahasiswa (Menunggu Konfirmasi)</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Jurusan</th>
                <th>Organisasi 1</th>
                <th>Organisasi 2</th>
                <th>Organisasi 3</th>
                <th>Alamat</th>
                <th>Deskripsi</th>
                <th>Berkas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftarans as $data)
            <tr>
                <td>{{ $data->user->name }}</td>
                <td>{{ $data->setting->nim }}</td>
                <td>{{ $data->setting->jurusan }}</td>
                <td>{{ $data->organization_1 }}</td>
                <td>{{ $data->organization_2 }}</td>
                <td>{{ $data->organization_3 }}</td>
                <td>{{ $data->alamat }}</td>
                <td>{{ $data->deskripsi }}</td>
                <td>
                    @if($data->file || $data->document_path)
                        <a href="{{ asset('storage/' . ($data->file ?? $data->document_path)) }}" target="_blank">Lihat File</a>
                    @else
                        Tidak ada
                    @endif
                </td>
                <td><span class="badge bg-warning text-dark">{{ $data->status }}</span></td>
                <td>
                    <form action="{{ route('admin.pendaftaran.updateStatus', ['id' => $data->id, 'status' => 'diterima']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-success btn-sm" title="Terima"><i class="fas fa-check"></i></button>
                    </form>
                    <form action="{{ route('admin.pendaftaran.updateStatus', ['id' => $data->id, 'status' => 'ditolak']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-danger btn-sm" title="Tolak"><i class="fas fa-times"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
