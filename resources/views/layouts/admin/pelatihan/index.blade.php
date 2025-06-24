@extends('layouts.app')

@section('title', 'Profile mahasiswa')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pelatihan untuk mahasiswa</h1>
            </div>

            @php
                $allowedRoles = ['alqarib', 'BDCA', 'BDCU', 'BDPRO', 'BDSC', 'BGK', 'BRadio', 'KMHDI', 'MABIDAR', 'Olahraga', 'PMKK', 'Pramuka', 'SSEC'];
            @endphp

            @if (in_array(auth()->user()->role, $allowedRoles))
                <div class="coming-soon-wrapper">
                    <div class="coming-soon-overlay">
                        <h1 class="display-1 fw-bold">COMING SOON</h1>
                        <p class="lead">Fitur ini sedang dalam pengembangan.</p>
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
