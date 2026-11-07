
@extends('layouts.admin')

@section('title', 'Detail Riwayat Deteksi')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.detection-histories.index') }}"
           class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat Deteksi
        </a>

        <h4 class="fw-bold mt-3 mb-1">Detail Hasil Deteksi</h4>
        <p class="text-muted mb-0">
            Informasi lengkap hasil klasifikasi kesegaran objek.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Gambar Objek</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $detectionHistory->image_path) }}"
                         alt="Gambar objek yang dideteksi"
                         class="img-fluid rounded"
                         style="max-height:400px;object-fit:contain;">

                    <div class="mt-3">
                        <span class="badge bg-light text-dark">
                            {{ ucfirst($detectionHistory->jenis_objek) }}
                        </span>
                        @if($detectionHistory->nama_objek)
                            <span class="badge bg-secondary">
                                {{ $detectionHistory->nama_objek }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Hasil Prediksi AI</h6>
                </div>

                <div class="card-body">
                    @php
                        $label = str_replace('_', ' ', $detectionHistory->hasil_prediksi);
                        $badgeClass = match($detectionHistory->hasil_prediksi) {
                            'Segar' => 'bg-success',
                            'Cukup_Segar' => 'bg-info text-dark',
                            'Kurang_Segar' => 'bg-warning text-dark',
                            'Tidak_Segar' => 'bg-danger',
                            default => 'bg-secondary',
                        };
                    @endphp

                    <div class="text-center py-3">
                        <small class="text-muted d-block mb-2">Kategori Kesegaran</small>
                        <span class="badge {{ $badgeClass }} fs-5 px-4 py-2">
                            {{ $label }}
                        </span>

                        <h2 class="fw-bold mt-3 mb-1">
                            {{ number_format((float) $detectionHistory->confidence, 2) }}%
                        </h2>
                        <p class="text-muted mb-0">Confidence Prediksi</p>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3">Probabilitas Setiap Kelas</h6>

                    @if(is_array($detectionHistory->probabilitas) && count($detectionHistory->probabilitas))
                        @foreach($detectionHistory->probabilitas as $class => $probability)
                            @php
                                $value = (float) $probability;
                                $percentage = $value <= 1 ? $value * 100 : $value;
                                $percentage = min(100, max(0, $percentage));
                                $progressClass = match(str_replace(' ', '_', $class)) {
                                    'Segar' => 'bg-success',
                                    'Cukup_Segar' => 'bg-info',
                                    'Kurang_Segar' => 'bg-warning',
                                    'Tidak_Segar' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                            @endphp

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-medium">
                                        {{ str_replace('_', ' ', $class) }}
                                    </span>
                                    <span class="text-muted">
                                        {{ number_format($percentage, 2) }}%
                                    </span>
                                </div>

                                <div class="progress" style="height:9px;">
                                    <div class="progress-bar {{ $progressClass }}"
                                         role="progressbar"
                                         style="width: {{ $percentage }}%"
                                         aria-valuenow="{{ $percentage }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">
                            Data probabilitas tidak tersedia.
                        </p>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Informasi Deteksi</h6>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5 text-muted">Nama Pengguna</div>
                        <div class="col-7 fw-semibold">
                            {{ $detectionHistory->user?->name ?? '-' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 text-muted">Email</div>
                        <div class="col-7">
                            {{ $detectionHistory->user?->email ?? '-' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 text-muted">Jenis Objek</div>
                        <div class="col-7">
                            {{ ucfirst($detectionHistory->jenis_objek) }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 text-muted">Nama Objek</div>
                        <div class="col-7">
                            {{ $detectionHistory->nama_objek ?? '-' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 text-muted">Tanggal Deteksi</div>
                        <div class="col-7">
                            {{ $detectionHistory->created_at?->format('d F Y, H:i:s') ?? '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-5 text-muted">ID Deteksi</div>
                        <div class="col-7">#{{ $detectionHistory->id }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
