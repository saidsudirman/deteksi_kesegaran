
@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Data Pengguna
        </a>
        <h4 class="fw-bold mt-3 mb-1">Detail Pengguna</h4>
        <p class="text-muted mb-0">Informasi akun dan aktivitas deteksi pengguna.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width:85px;height:85px;font-size:32px;">
                        <i class="fas fa-user"></i>
                    </div>

                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    @if($user->role === 'admin')
                        <span class="badge bg-primary">Administrator</span>
                    @else
                        <span class="badge bg-success">Pengguna</span>
                    @endif

                    <hr>

                    <div class="text-start">
                        <div class="mb-3">
                            <small class="text-muted d-block">ID Pengguna</small>
                            <span class="fw-semibold">#{{ $user->id }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Tanggal Pendaftaran</small>
                            <span class="fw-semibold">
                                {{ $user->created_at?->format('d F Y, H:i') ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <small class="text-muted d-block">Total Deteksi</small>
                            <span class="fw-semibold">{{ $user->detection_histories_count }} kali</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="btn btn-outline-warning w-100 mt-4">
                        <i class="fas fa-edit me-2"></i>Edit Pengguna
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Riwayat Deteksi Pengguna</h6>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Gambar</th>
                                <th>Objek</th>
                                <th>Hasil Prediksi</th>
                                <th>Akurasi Keyakinan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histories as $history)
                                <tr>
                                    <td class="ps-3">
                                        <img src="{{ asset('storage/' . $history->image_path) }}"
                                             alt="Gambar deteksi"
                                             class="rounded"
                                             style="width:55px;height:55px;object-fit:cover;">
                                    </td>
                                    <td>
                                        {{ ucfirst($history->jenis_objek) }}
                                        @if($history->nama_objek)
                                            <small class="text-muted d-block">{{ $history->nama_objek }}</small>
                                        @endif
                                    </td>
                                    <td>{{ str_replace('_', ' ', $history->hasil_prediksi) }}</td>
                                    <td>{{ number_format((float) $history->confidence, 2) }}%</td>
                                    <td>{{ $history->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada riwayat deteksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white">
                    {{ $histories->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
