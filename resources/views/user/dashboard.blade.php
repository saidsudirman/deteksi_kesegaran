
@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Dashboard</h3>
    <p class="text-secondary">Ringkasan aktivitas deteksi kesegaran buah dan sayuran.</p>
</div>

<div class="welcome-card mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="fw-bold">
                Selamat Datang, {{ auth()->user()->name }}!
            </h4>

            <p class="mb-3">
                Periksa tingkat kesegaran buah dan sayuran menggunakan teknologi Artificial Intelligence.
            </p>

            <a href="#" class="btn btn-light fw-semibold">
                <i class="fas fa-camera me-2"></i> Mulai Deteksi
            </a>
        </div>

        <div class="col-md-4 text-center d-none d-md-block">
            <i class="fas fa-leaf" style="font-size: 90px; opacity: .8;"></i>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card p-3">
            <div class="text-secondary small">Total Deteksi</div>
            <h3 class="fw-bold mt-2">{{ $totalDeteksi }}</h3>
            <i class="fas fa-camera text-primary fs-4"></i>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card p-3">
            <div class="text-secondary small">Hasil Segar</div>
            <h3 class="fw-bold mt-2">{{ $totalSegar }}</h3>
            <i class="fas fa-leaf text-success fs-4"></i>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card p-3">
            <div class="text-secondary small">Tidak Segar</div>
            <h3 class="fw-bold mt-2">{{ $totalTidakSegar }}</h3>
            <i class="fas fa-exclamation-circle text-danger fs-4"></i>
        </div>
    </div>
</div>

<div class="card content-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Deteksi Terakhir</h5>
        <a href="#" class="text-success text-decoration-none small">
            Lihat Riwayat
        </a>
    </div>

    @if ($deteksiTerakhir)
        <div class="row align-items-center">
            <div class="col-md-8">
                <p class="text-secondary mb-1">Kategori objek</p>
                <h6 class="fw-bold">{{ ucfirst($deteksiTerakhir->jenis_objek) }}</h6>

                <p class="text-secondary mb-1 mt-3">Hasil prediksi</p>
                <h6 class="fw-bold">{{ str_replace('_', ' ', $deteksiTerakhir->hasil_prediksi) }}</h6>

                <p class="text-secondary mb-1 mt-3">Confidence</p>
                <h6 class="fw-bold">{{ number_format($deteksiTerakhir->confidence, 2) }}%</h6>

                <small class="text-secondary">
                    {{ $deteksiTerakhir->created_at->format('d M Y, H:i') }}
                </small>
            </div>
        </div>
    @else
        <div class="text-center py-4">
            <i class="fas fa-image text-secondary mb-3" style="font-size: 45px;"></i>
            <h6 class="fw-semibold">Belum Ada Hasil Deteksi</h6>
            <p class="text-secondary mb-0">
                Silakan mulai deteksi untuk melihat hasil analisis kesegaran buah atau sayuran.
            </p>
        </div>
    @endif
</div>
@endsection
