<div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="kategori" class="form-select" required>
        @foreach(['sejarah'=>'Sejarah','fasilitas'=>'Fasilitas','koleksi'=>'Koleksi','umum'=>'Umum'] as $k=>$v)
            <option value="{{ $k }}" {{ (old('kategori', $informasi->kategori ?? '') === $k) ? 'selected' : '' }}>{{ $v }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="judul" class="form-control" value="{{ old('judul', $informasi->judul ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" rows="6" class="form-control" required>{{ old('deskripsi', $informasi->deskripsi ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Gambar {{ isset($informasi) ? '(kosongkan jika tidak diganti)' : '' }}</label>
    <input type="file" name="gambar" class="form-control" accept="image/*">
    @isset($informasi->gambar)
        <img src="{{ $informasi->gambar_url }}" width="100" class="mt-2 rounded">
    @endisset
</div>
<div class="form-check mb-3">
    <input type="checkbox" name="status_aktif" class="form-check-input" value="1" {{ old('status_aktif', $informasi->status_aktif ?? true) ? 'checked' : '' }}>
    <label class="form-check-label">Tampilkan ke pengunjung</label>
</div>
