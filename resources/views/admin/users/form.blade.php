
<div class="mb-3">
    <label class="form-label fw-semibold">Nama Lengkap</label>
    <input type="text" name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $user->name ?? '') }}"
        placeholder="Masukkan nama lengkap" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Alamat Email</label>
    <input type="email" name="email"
        class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $user->email ?? '') }}"
        placeholder="nama@email.com" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">
        Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '' }}
    </label>
    <input type="password" name="password"
        class="form-control @error('password') is-invalid @enderror"
        {{ isset($user) ? '' : 'required' }}
        placeholder="Minimal 8 karakter">
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Konfirmasi Password</label>
    <input type="password" name="password_confirmation"
        class="form-control" placeholder="Ulangi password"
        {{ isset($user) ? '' : 'required' }}>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Role Pengguna</label>
    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
        <option value="">Pilih Role</option>
        <option value="user" @selected(old('role', $user->role ?? 'user') === 'user')>User</option>
        <option value="admin" @selected(old('role', $user->role ?? '') === 'admin')>Admin</option>
    </select>
    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
