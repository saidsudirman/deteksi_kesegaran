
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Dashboard</h3>
    <p class="text-secondary">Selamat datang di panel administrator FreshAI.</p>
</div>

<div class="row g-4">
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="text-secondary small">Total Pengguna</div>
            <h3 class="fw-bold mt-2">{{ number_format($totalPengguna) }}</h3>
            <i class="fas fa-users text-success fs-4"></i>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="text-secondary small">Total Deteksi</div>
            <h3 class="fw-bold mt-2">{{ number_format($totalDeteksi) }}</h3>
            <i class="fas fa-camera text-primary fs-4"></i>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="text-secondary small">Hasil Segar</div>
            <h3 class="fw-bold mt-2">{{ number_format($hasilSegar) }}</h3>
            <i class="fas fa-leaf text-success fs-4"></i>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="text-secondary small">Tidak Segar</div>
            <h3 class="fw-bold mt-2">{{ number_format($tidakSegar) }}</h3>
            <i class="fas fa-exclamation-circle text-danger fs-4"></i>
        </div>
    </div>
</div>

<div class="card stat-card mt-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-1">Aktivitas Deteksi Terbaru</h5>
            <p class="text-secondary small mb-0">
                Lima aktivitas deteksi terakhir dari pengguna.
            </p>
        </div>
    </div>

    @if ($aktivitasTerbaru->count())
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Pengguna</th>
                        <th>Jenis Objek</th>
                        <th>Hasil Prediksi</th>
                        <th>Confidence</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aktivitasTerbaru as $aktivitas)
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

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $aktivitas->user->name ?? 'Pengguna tidak ditemukan' }}</td>
                            <td>{{ ucfirst($aktivitas->jenis_objek) }}</td>
                            <td>
                                <span class="badge bg-{{ $colors[$aktivitas->hasil_prediksi] ?? 'secondary' }}">
                                    {{ $labels[$aktivitas->hasil_prediksi] ?? $aktivitas->hasil_prediksi }}
                                </span>
                            </td>
                            <td>
                                {{ number_format((float) $aktivitas->confidence, 2) }}%
                            </td>
                            <td>
                                {{ $aktivitas->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-4">
            <i class="fas fa-chart-bar fa-2x text-muted mb-3"></i>
            <p class="text-secondary mb-0">Belum ada aktivitas deteksi.</p>
        </div>
    @endif
</div>
@endsection
