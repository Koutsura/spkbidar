@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
@if (auth()->user()->role == 'mahasiswa')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <h2 class="mb-4">Selamat datang mahasiswa</h2>

        <div class="row">
            @php
                $ukms = [
                    [
                        'img' => 'bdca.webp',
                        'title' => 'Bina Darma Cyber Army(@bidarcyberarmy)',
                        'desc' => 'UKM yang berfokus pada keamanan siber dan pelatihan ethical hacking.'
                    ],
                    [
                        'img' => 'qarib.webp',
                        'title' => 'LDK ALQORIB(@ldkalqoribbidar)',
                        'desc' => 'Lembaga dakwah kampus Islam yang membina rohani, akhlak, dan ukhuwah Islamiyah.'
                    ],
                    [
                        'img' => 'PMKK.webp',
                        'title' => 'Persekutuan Mahasiswa Kristen & Katolik(@pmkkubd)',
                        'desc' => 'Wadah pengembangan iman dan kebersamaan bagi mahasiswa Kristen dan Katolik.'
                    ],
                    [
                        'img' => 'kmhdi.webp',
                        'title' => 'Kesatuan Mahasiswa Hindu Darma Indonesia(@kmhdipalembang)',
                        'desc' => 'UKM keagamaan Hindu yang berfokus pada pembinaan spiritual dan budaya Hindu.'
                    ],
                    [
                        'img' => 'mabidar.webp',
                        'title' => 'Mahasiswa Pencinta Alam(@mabidar.palembang)',
                        'desc' => 'UKM bagi pecinta alam, menjelajahi dan menjaga kelestarian lingkungan hidup.'
                    ],
                    [
                        'img' => 'BGK.webp',
                        'title' => 'Bujang Gadis Kampus(@bgk_bidar)',
                        'desc' => 'UKM pengembangan kepribadian, etika, dan representasi duta kampus.'
                    ],
                    [
                        'img' => 'futsal.webp',
                        'title' => 'Futsal(@futsalbinadarma)',
                        'desc' => 'UKM olahraga yang fokus pada pengembangan kemampuan dan kompetisi futsal.'
                    ],
                    [
                        'img' => 'pramuka.webp',
                        'title' => 'Pramuka(@pramuka_ubd)',
                        'desc' => 'UKM kepramukaan yang melatih kemandirian, kepemimpinan, dan semangat kebangsaan.'
                    ],
                    [
                        'img' => 'EDS.webp',
                        'title' => 'EDS South Sumatera English Community(@eds_bidar)',
                        'desc' => 'UKM bahasa Inggris yang fokus pada debat, public speaking, dan kompetisi English.'
                    ],
                    [
                        'img' => 'basket.webp',
                        'title' => 'Basket Club(@bidarbasketclub)',
                        'desc' => 'UKM olahraga basket yang aktif berlatih dan mengikuti turnamen antar kampus.'
                    ],
                    [
                        'img' => 'choir.webp',
                        'title' => 'Paduan Suara Mahasiswa Universitas Bina Darma(@bidarians_choir)',
                        'desc' => 'UKM seni suara yang menyalurkan bakat bernyanyi dan tampil di berbagai acara kampus.'
                    ],
                ];
            @endphp

            @foreach ($ukms as $ukm)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100" style="cursor: pointer;"
                         data-bs-toggle="modal"
                         data-bs-target="#ukmModal"
                         data-title="{{ $ukm['title'] }}"
                         data-desc="{{ $ukm['desc'] }}">
                        <img src="{{ asset('img/' . $ukm['img']) }}" class="card-img-top img-fluid" alt="{{ $ukm['title'] }}">
                        <div class="card-body p-2">
                            <p class="img-caption mb-1">{{ $ukm['title'] }}</p>
                            <p class="text-muted small">Klik untuk lihat deskripsi lengkap</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

<!-- Modal untuk Pop-up Deskripsi UKM -->
<div class="modal fade" id="ukmModal" tabindex="-1" aria-labelledby="ukmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ukmModalLabel">Judul UKM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="ukmModalDesc">
                Deskripsi UKM akan muncul di sini.
            </div>
        </div>
    </div>
</div>
        @endif

        @if (auth()->user()->role == 'superadmin')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <h2 class="mb-4 text-center">Status Pendaftaran Mahasiswa</h2>

        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Pending</h5>
                        <h3>{{ $count_pending }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">Diterima</h5>
                        <h3>{{ $count_diterima }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Ditolak</h5>
                        <h3>{{ $count_ditolak }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
            @endif
@php
    $ukmRoles = [
        'alqarib'   => 'UKM LDK ALQORIB',
        'BDCA'      => 'UKM Bina Darma Cyber Army (BDCA)',
        'BDCU'      => 'UKM Binadarma Debat Union (BDCU)',
        'BDPRO'     => 'UKM Bina Darma Programmer (BDPRO)',
        'BDSC'      => 'UKM Panduan Suara Mahasiswa (BDSC)',
        'BGK'       => 'UKM Bujang Gadis Kampus (BGK)',
        'BRadio'    => 'UKM Bina Darma Radio (B-Radio)',
        'KMHDI'     => 'UKM Kesatuan Mahasiswa Hindu Dharma Indonesia (KMHDI)',
        'MABIDAR'   => 'UKM Mahasiswa Pencinta Alam (MABIDAR)',
        'Olahraga'  => 'UKM Olahraga',
        'PMKK'      => 'UKM Persekutuan Mahasiswa Kristen & Katolik (PMKK)',
        'Pramuka'   => 'UKM Pramuka',
        'SSEC'      => 'UKM EDS South Sumatera English Community (SSEC)',
    ];

    $userRole = auth()->user()->role;
    $namaUKM = $ukmRoles[$userRole] ?? $userRole;
@endphp
@if (in_array($userRole, array_keys($ukmRoles)))
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <h2 class="mb-4 text-center">Status Pendaftaran Mahasiswa</h2>

        @if (in_array($userRole, array_keys($ukmRoles)) && isset($jumlahDiterimaUKM))
            <div class="row mt-4 justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Rekap Mahasiswa Diterima di {{ $namaUKM }}</h5>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-4 text-success">{{ $jumlahDiterimaUKM }}</h1>
                            <p class="mb-0">
                                Mahasiswa yang memilih <strong>{{ $namaUKM }}</strong> sebagai salah satu pilihan organisasi dan telah <strong>DITERIMA</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
             <div class="table-responsive">
                <form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Cari nama mahasiswa..." value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Cari</button>
    </div>
</form>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Jurusan</th>
                <th>Tahun Angkatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftarans as $data)
                <tr>
                    <td>{{ $data->user->name ?? '-' }}</td>
                    <td>{{ $data->nim ?? '-' }}</td>
                    <td>{{ $data->jurusan ?? '-' }}</td>
                    <td>{{ $data->tahun_angkatan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
        @endif
    </section>
</div>
@endsection


@push('scripts')
    <!-- JS Libraries -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ukmCards = document.querySelectorAll('.card[data-bs-toggle="modal"]');
        const modalTitle = document.getElementById('ukmModalLabel');
        const modalDesc = document.getElementById('ukmModalDesc');

        ukmCards.forEach(card => {
            card.addEventListener('click', function () {
                modalTitle.textContent = this.getAttribute('data-title');
                modalDesc.textContent = this.getAttribute('data-desc');
            });
        });
    });
</script>

    <!-- Page Specific JS File -->
@endpush
