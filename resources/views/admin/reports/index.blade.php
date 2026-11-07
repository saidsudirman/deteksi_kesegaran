
@extends('layouts.admin')

@section('title', 'Laporan Deteksi')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Laporan Deteksi</h4>
            <p class="text-muted mb-0">
                Statistik dan analisis hasil deteksi kesegaran FreshAI.
            </p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-success">
            <i class="fas fa-print me-2"></i>Cetak Laporan
        </button>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="date_from" class="form-control"
                            value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Akhir</label>
                        <input type="date" name="date_to" class="form-control"
                            value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-filter me-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-light">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Deteksi</p>
                            <h3 class="fw-bold mb-0">{{ number_format($totalDetections) }}</h3>
                        </div>
                        <div class="rounded-3 bg-success-subtle text-success p-3">
                            <i class="fas fa-camera fa-lg"></i>
                        </div>
                    </div>
                    <small class="text-muted">Seluruh aktivitas deteksi</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Deteksi Buah</p>
                            <h3 class="fw-bold mb-0">{{ number_format($fruitCount) }}</h3>
                        </div>
                        <div class="rounded-3 bg-warning-subtle text-warning p-3">
                            <i class="fas fa-apple-whole fa-lg"></i>
                        </div>
                    </div>
                    <small class="text-muted">Objek kategori buah</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Deteksi Sayuran</p>
                            <h3 class="fw-bold mb-0">{{ number_format($vegetableCount) }}</h3>
                        </div>
                        <div class="rounded-3 bg-info-subtle text-info p-3">
                            <i class="fas fa-carrot fa-lg"></i>
                        </div>
                    </div>
                    <small class="text-muted">Objek kategori sayuran</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Rata-rata Confidence</p>
                            <h3 class="fw-bold mb-0">
                                {{ number_format((float) $averageConfidence, 2) }}%
                            </h3>
                        </div>
                        <div class="rounded-3 bg-primary-subtle text-primary p-3">
                            <i class="fas fa-chart-line fa-lg"></i>
                        </div>
                    </div>
                    <small class="text-muted">Rata-rata keyakinan prediksi AI</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Distribusi Hasil Prediksi</h6>
                </div>
                <div class="card-body">
                    <div style="height:320px;">
                        <canvas id="predictionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Aktivitas Deteksi Harian</h6>
                </div>
                <div class="card-body">
                    <div style="height:320px;">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">Lima Deteksi Terbaru</h6>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Pengguna</th>
                        <th>Gambar</th>
                        <th>Jenis</th>
                        <th>Hasil Prediksi</th>
                        <th>Confidence</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentHistories as $history)
                        <tr>
                            <td class="ps-4">
                                {{ $history->user?->name ?? 'Pengguna tidak tersedia' }}
                            </td>
                            
                            <td>
                                <img src="{{ asset('storage/' . $history->image_path) }}"
                                     alt="Gambar deteksi"
                                     class="rounded"
                                     style="width:55px;height:55px;object-fit:cover;">
                            </td>
                            <td>{{ ucfirst($history->jenis_objek) }}</td>
                            <td>{{ str_replace('_', ' ', $history->hasil_prediksi) }}</td>
                            <td>{{ number_format((float) $history->confidence, 2) }}%</td>
                            <td>{{ $history->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data deteksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .sidebar, .topbar, nav, form, button {
            display: none !important;
        }

        .main-content {
            margin: 0 !important;
            padding: 0 !important;
        }

        .card {
            break-inside: avoid;
            box-shadow: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const predictionLabels = @json($classLabels);
    const predictionValues = @json($predictionCounts);

    const dailyLabels = @json(
        $dailyData->pluck('tanggal')->map(
            fn ($date) => \Carbon\Carbon::parse($date)->format('d/m/Y')
        )->values()
    );

    const dailyValues = @json($dailyData->pluck('total')->values());

    new Chart(document.getElementById('predictionChart'), {
        type: 'doughnut',
        data: {
            labels: predictionLabels.map(label => label.replaceAll('_', ' ')),
            datasets: [{
                data: predictionValues,
                backgroundColor: ['#198754', '#0dcaf0', '#ffc107', '#dc3545'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    new Chart(document.getElementById('dailyChart'), {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Jumlah Deteksi',
                data: dailyValues,
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.12)',
                fill: true,
                tension: 0.35,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endpush
