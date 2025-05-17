@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tes Rekomendasi Unit Kegiatan Mahasiswa (UKM)</h1>
        </div>
<div style="text-align:center; margin-top: 50px;">
    <h2>Ayo tes rekomendasi organisasi UKM terlebih dahulu</h2>
    <a href="{{ route('spk.form') }}" style="margin-top: 20px; display: inline-block; padding: 10px 20px; background-color: #1D4ED8; color: white; border-radius: 5px; text-decoration: none;">
        Mulai Tes
    </a>
</div>
</section>
</div>
@endsection
