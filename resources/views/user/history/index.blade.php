
@extends('layouts.user')

@section('title', 'Riwayat Deteksi')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Riwayat Deteksi</h3>
        <p class="text-muted mb-0">Daftar hasil pemeriksaan kesegaran buah dan sayuran.</p>
    </div>
    <a href="{{ route('user.detection') }}" class="btn btn-fresh mt-2 mt-md-0">
        <i class="fas fa-camera me-2"></i>Deteksi Baru
    </a>
</div>

<div class="card content-card">
    <div class="card-body p-4">
        @if ($histories->count())
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Gambar</th>
                            <th>Jenis Objek</th>
                            <th>Hasil Prediksi</th>
                            <th>Confidence</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $history)
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
                                <td>{{ $histories->firstItem() + $loop->index }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $history->image_path) }}"
                                        alt="Gambar deteksi"
                                        class="rounded"
                                        style="width: 65px; height: 55px; object-fit: cover;">
                                </td>
                                <td>{{ ucfirst($history->jenis_objek) }}</td>
                                <td>
                                    <span class="badge bg-{{ $colors[$history->hasil_prediksi] ?? 'secondary' }}">
                                        {{ $labels[$history->hasil_prediksi] ?? $history->hasil_prediksi }}
                                    </span>
                                </td>
                                <td class="fw-semibold">
                                    {{ number_format((float) $history->confidence, 2) }}%
                                </td>
                                <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('user.history.show', $history->id) }}"
                                        class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $histories->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold">Belum Ada Riwayat Deteksi</h5>
                <p class="text-muted">Silakan lakukan deteksi kesegaran buah atau sayuran terlebih dahulu.</p>
                <a href="{{ route('user.detection') }}" class="btn btn-fresh">
                    Mulai Deteksi
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
