@extends('layouts.app')

@section('title', 'Manajemen Pendaftaran')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Pendaftaran Mahasiswa (Menunggu Konfirmasi)</h1>
        </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
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
                        @if($data->upload_file)
    <a href="{{ asset('storage/' . $data->upload_file) }}" target="_blank" class="btn btn-info btn-sm" title="Lihat Berkas">
        @dump (asset('storage/' . $data->upload_file))
        <i class="fas fa-file-pdf"></i> Lihat File
    </a>
@else
    <span class="text-muted">Tidak ada</span>
@endif

                    </td>
                    <td><span class="badge bg-warning text-dark">{{ $data->status }}</span></td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('admin.pendaftaran.updateStatus', ['id' => $data->id, 'status' => 'diterima']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-success btn-sm" title="Terima" data-bs-toggle="tooltip" data-bs-placement="top" title="Terima pendaftaran"><i class="fas fa-check"></i></button>
                            </form>
                            <form action="{{ route('admin.pendaftaran.updateStatus', ['id' => $data->id, 'status' => 'ditolak']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-danger btn-sm" title="Tolak" data-bs-toggle="tooltip" data-bs-placement="top" title="Tolak pendaftaran"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
</div>

@push('scripts')
<script>
    // Enable tooltips for buttons
    var tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endpush

@endsection
