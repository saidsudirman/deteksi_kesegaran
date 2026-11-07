
@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Data Pengguna
        </a>
        <h4 class="fw-bold mt-3 mb-1">Tambah Pengguna</h4>
        <p class="text-muted mb-0">Tambahkan akun baru ke dalam sistem FreshAI.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                @include('admin.users.form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Simpan Pengguna
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
