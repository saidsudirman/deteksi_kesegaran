
@extends('layouts.user')

@section('title', 'Detail Riwayat Deteksi')

@section('content')
@php
    $labels = [
        'Segar' => 'Segar',
        'Cukup_Segar' => 'Cukup Segar',
        'Kurang_Segar' => 'Kurang Segar',
        'Tidak_Segar' => 'Tidak Segar',
    ];

    $colors = [
        'Segar' => 'success',
        'Cukup_Segar' => 'info',
        'Kurang_Segar' => 'warning',
        'Tidak_Segar' => 'danger',
    ];
@endphp

<div class="mb-4">
    <a href="{{ route('user.history.index') }}" class="text-decoration-none text-success">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
    </a>
    <h3 class="fw-bold mt-3 mb-1">Detail Hasil Deteksi</h3>
    <p class="text-muted mb-0">Informasi lengkap hasil pemeriksaan kesegaran.</p>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Gambar yang Diperiksa</h5>

                <img src="{{ asset('storage/' . $history->image_path) }}"
                    alt="Gambar objek yang dideteksi"
                    class="img-fluid rounded w-100"
                    style="max-height: 350px; object-fit: contain; background: #f5f7f5;">

                <div class="mt-3">
                    <small class="text-muted">Jenis Objek</small>
                    <h6 class="fw-semibold">{{ ucfirst($history->jenis_objek) }}</h6>

                    <small class="text-muted">Tanggal Deteksi</small>
                    <h6 class="fw-semibold">{{ $history->created_at->format('d F Y, H:i') }}</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card content-card mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Hasil Prediksi AI</h5>

                <div class="mb-3">
                    <small class="text-muted">Kategori Kesegaran</small>
                    <h3>
                        <span class="badge bg-{{ $colors[$history->hasil_prediksi] ?? 'secondary' }}">
                            {{ $labels[$history->hasil_prediksi] ?? $history->hasil_prediksi }}
                        </span>
                    </h3>
                </div>

                <small class="text-muted">Confidence</small>
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-semibold">Tingkat Keyakinan Model</span>
                    <span class="fw-bold">
                        {{ number_format((float) $history->confidence, 2) }}%
                    </span>
                </div>

                <div class="progress" style="height: 12px;">
                    <div class="progress-bar bg-success"
                        style="width: {{ min(max((float) $history->confidence, 0), 100) }}%">
                    </div>
                </div>
            </div>
        </div>

        <div class="card content-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Probabilitas Setiap Kelas</h5>

                @forelse ($history->probabilitas ?? [] as $class => $value)
                    @php
                        $percentage = min(max((float) $value, 0), 100);
                    @endphp

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>{{ $labels[$class] ?? $class }}</span>
                            <span class="fw-semibold">{{ number_format($percentage, 2) }}%</span>
                        </div>

                        <div class="progress" style="height: 9px;">
                            <div class="progress-bar bg-success"
                                style="width: {{ $percentage }}%">
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Data probabilitas tidak tersedia.</p>
                @endforelse
            </div>
        </div>

        <div class="alert alert-info mt-4">
            <i class="fas fa-info-circle me-2"></i>
            Hasil deteksi merupakan prediksi berdasarkan model AI dan bukan jaminan mutlak kondisi kesegaran objek.
        </div>
    </div>
</div>
@endsection
