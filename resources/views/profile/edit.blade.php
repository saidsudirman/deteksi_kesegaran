@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.user')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Profil Saya</h3>
        <p class="text-muted mb-0">Kelola informasi akun dan keamanan FreshAI.</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>Profil berhasil diperbarui.
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>Password berhasil diperbarui.
        </div>
    @endif

    <div class="row g-4">

        <!-- Informasi Akun -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center p-4">

                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                        style="width:100px;height:100px;background:#e3f1e8;color:#246344;font-size:38px;">
                        <i class="fas fa-user"></i>
                    </div>

                    <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>

                    <p class="text-muted small mb-3">
                        {{ auth()->user()->email }}
                    </p>

                    <span class="badge rounded-pill px-3 py-2"
                        style="background:#e3f1e8;color:#246344;">
                        <i class="fas fa-shield-alt me-1"></i>
                        {{ ucfirst(auth()->user()->role) }}
                    </span>

                    <hr class="my-4">

                    <div class="text-start">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted small">ID Pengguna</span>
                            <span class="fw-semibold small">{{ auth()->user()->id }}</span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Bergabung</span>
                            <span class="fw-semibold small">
                                {{ auth()->user()->created_at?->format('d M Y') ?? '-' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold">
                        <i class="fas fa-info-circle text-success me-2"></i>
                        Informasi
                    </h6>
                    <p class="text-muted small mb-0">
                        Pastikan informasi akun selalu diperbarui agar dapat menggunakan layanan FreshAI dengan baik.
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Profil -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">

                    <div class="mb-4">
                        <h5 class="fw-bold mb-1">Informasi Pribadi</h5>
                        <p class="text-muted small mb-0">
                            Perbarui nama dan alamat email akun kamu.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text"
                                name="name"
                                class="form-control rounded-3 py-2 @error('name') is-invalid @enderror"
                                value="{{ old('name', auth()->user()->name) }}"
                                required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Alamat Email</label>
                            <input type="email"
                                name="email"
                                class="form-control rounded-3 py-2 @error('email') is-invalid @enderror"
                                value="{{ old('email', auth()->user()->email) }}"
                                required>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-fresh px-4 py-2 rounded-3">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </form>

                </div>
            </div>

            <!-- Form Password -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="mb-4">
                        <h5 class="fw-bold mb-1">Keamanan Akun</h5>
                        <p class="text-muted small mb-0">
                            Ubah password untuk menjaga keamanan akun FreshAI.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Saat Ini</label>
                            <input type="password"
                                name="current_password"
                                class="form-control rounded-3 py-2 @error('current_password', 'updatePassword') is-invalid @enderror"
                                required>

                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password"
                                name="password"
                                class="form-control rounded-3 py-2 @error('password', 'updatePassword') is-invalid @enderror"
                                required>

                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password"
                                name="password_confirmation"
                                class="form-control rounded-3 py-2"
                                required>
                        </div>

                        <button type="submit" class="btn btn-fresh px-4 py-2 rounded-3">
                            <i class="fas fa-lock me-2"></i>Ubah Password
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection