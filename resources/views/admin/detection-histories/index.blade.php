
@extends('layouts.admin')

@section('title', 'Riwayat Deteksi')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Riwayat Deteksi</h4>
        <p class="text-muted mb-0">
            Pantau seluruh aktivitas deteksi kesegaran buah dan sayuran.
        </p>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.detection-histories.index') }}" method="GET">
                <div class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nama pengguna atau objek..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="jenis_objek" class="form-select">
                            <option value="">Semua Jenis Objek</option>
                            <option value="buah" @selected(request('jenis_objek') === 'buah')>
                                Buah
                            </option>
                            <option value="sayuran" @selected(request('jenis_objek') === 'sayuran')>
                                Sayuran
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="hasil_prediksi" class="form-select">
                            <option value="">Semua Hasil Prediksi</option>
                            <option value="Segar" @selected(request('hasil_prediksi') === 'Segar')>
                                Segar
                            </option>
                            <option value="Cukup_Segar" @selected(request('hasil_prediksi') === 'Cukup_Segar')>
                                Cukup Segar
                            </option>
                            <option value="Kurang_Segar" @selected(request('hasil_prediksi') === 'Kurang_Segar')>
                                Kurang Segar
                            </option>
                            <option value="Tidak_Segar" @selected(request('hasil_prediksi') === 'Tidak_Segar')>
                                Tidak Segar
                            </option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-success w-100" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                @if(request()->hasAny(['search', 'jenis_objek', 'hasil_prediksi']))
                    <div class="mt-3">
                        <a href="{{ route('admin.detection-histories.index') }}"
                           class="text-decoration-none text-muted small">
                            <i class="fas fa-rotate-left me-1"></i>Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">Daftar Aktivitas Deteksi</h6>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No.</th>
                        <th>Pengguna</th>
                        <th>Gambar</th>
                        <th>Jenis Objek</th>
                        <th>Hasil Prediksi</th>
                        <th>Confidence</th>
                        <th>Tanggal Deteksi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($histories as $index => $history)
                        <tr>
                            <td class="ps-4">
                                {{ $histories->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $history->user?->name ?? 'Pengguna tidak tersedia' }}
                                </div>
                                <small class="text-muted">
                                    {{ $history->user?->email ?? '-' }}
                                </small>
                            </td>

                            <td>
                                <img src="{{ asset('storage/' . $history->image_path) }}"
                                     alt="Gambar deteksi"
                                     class="rounded"
                                     style="width:55px;height:55px;object-fit:cover;">
                            </td>

                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($history->jenis_objek) }}
                                </span>
                                @if($history->nama_objek)
                                    <small class="d-block text-muted mt-1">
                                        {{ $history->nama_objek }}
                                    </small>
                                @endif
                            </td>

                            <td>
                                @php
                                    $label = str_replace('_', ' ', $history->hasil_prediksi);
                                    $badgeClass = match($history->hasil_prediksi) {
                                        'Segar' => 'bg-success',
                                        'Cukup_Segar' => 'bg-info text-dark',
                                        'Kurang_Segar' => 'bg-warning text-dark',
                                        'Tidak_Segar' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp

                                <span class="badge {{ $badgeClass }}">
                                    {{ $label }}
                                </span>
                            </td>

                            <td class="fw-semibold">
                                {{ number_format((float) $history->confidence, 2) }}%
                            </td>

                            <td>
                                {{ $history->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.detection-histories.show', $history) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Detail Deteksi">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-clock fa-2x mb-3 d-block"></i>
                                Belum ada riwayat deteksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan {{ $histories->firstItem() ?? 0 }}–{{ $histories->lastItem() ?? 0 }}
                    dari {{ $histories->total() }} riwayat
                </small>

                {{ $histories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
