<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">No. Telepon</label>
        <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="pengunjung" {{ (old('role', $user->role ?? '') === 'pengunjung') ? 'selected' : '' }}>Pengunjung</option>
            <option value="admin" {{ (old('role', $user->role ?? '') === 'admin') ? 'selected' : '' }}>Admin</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Kata Sandi {{ isset($user) ? '(kosongkan jika tidak diganti)' : '' }}</label>
        <input type="password" name="password" class="form-control" minlength="6" {{ isset($user) ? '' : 'required' }}>
    </div>
</div>
<div class="mt-4"></div>
