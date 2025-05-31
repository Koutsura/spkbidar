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
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/bdca.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 1">
                    <div class="card-body p-2">
                        <p class="img-caption">Bina Darma Cyber Army(@bidarcyberarmy)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/qarib.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 2">
                    <div class="card-body p-2">
                        <p class="img-caption">LDK ALQORIB(@ldkalqoribbidar)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/PMKK.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 3">
                    <div class="card-body p-2">
                        <p class="img-caption">Persekutuan Mahasiswa Kristen & Katolik(@pmkkubd)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/kmhdi.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 4">
                    <div class="card-body p-2">
                        <p class="img-caption">Kesatuan Mahasiswa Hindu Darma Indonesia(@kmhdipalembang)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/mabidar.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 5">
                    <div class="card-body p-2">
                        <p class="img-caption">Mahasiswa Pencinta Alam(@mabidar.palembang)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/BGK.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 6">
                    <div class="card-body p-2">
                        <p class="img-caption">Bujang Gadis Kampus(@bgk_bidar)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/futsal.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 7">
                    <div class="card-body p-2">
                        <p class="img-caption">Futsal(@futsalbinadarma)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/seni.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 8">
                    <div class="card-body p-2">
                        <p class="img-caption">Seni(@ukmseni_binadarma)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/pramuka.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 9">
                    <div class="card-body p-2">
                        <p class="img-caption">Pramuka(@pramuka_ubd)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/EDS.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 10">
                    <div class="card-body p-2">
                        <p class="img-caption">EDS South Sumatera English Community(@eds_bidar)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/BTV.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 10">
                    <div class="card-body p-2">
                        <p class="img-caption">Binadarma TV(@binadarmatv)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/basket.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 10">
                    <div class="card-body p-2">
                        <p class="img-caption">Basket Club(@bidarbasketclub)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/data_science.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 10">
                    <div class="card-body p-2">
                        <p class="img-caption">Data Science(@datascience.ubd)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/multimedia.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 10">
                    <div class="card-body p-2">
                        <p class="img-caption">Multimedia(@multimedia.ubd)</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/taekwondo.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 10">
                    <div class="card-body p-2">
                        <p class="img-caption">Taekwondo(@taekwondo_binadarma)</p>
                    </div>
                </div>
            </div>
             <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('img/choir.webp') }}" class="card-img-top img-fluid" alt="Mahasiswa 10">
                    <div class="card-body p-2">
                        <p class="img-caption">Paduan Suara Mahasiswa Universitas Bina Darma(@bidarians_choir)</p>
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
<h2 class="mb-4 text-center">Selamat datang admin</h2>
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <img src="{{ asset('img/UKM.webp') }}" class="card-img-top img-fluid" alt="Admin">
            <div class="card-body p-2">
                <p class="img-caption">Pembina Organisasi Mahasiswa (ORMAWA) Universitas Bina Darma</p>
            </div>
        </div>
    </div>
</div>
            @endif
    </section>
</div>
@endsection


@push('scripts')
    <!-- JS Libraries -->

    <!-- Page Specific JS File -->
@endpush
