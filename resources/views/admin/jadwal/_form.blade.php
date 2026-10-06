<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Hari</label>
        <select name="hari" class="form-select" required>
            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                <option value="{{ $h }}" {{ (old('hari', $jadwal->hari ?? '') === $h) ? 'selected' : '' }}>{{ $h }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Jam Mulai</label>
        <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', isset($jadwal) ? substr($jadwal->jam_mulai,0,5) : '09:00') }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Jam Selesai</label>
        <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', isset($jadwal) ? substr($jadwal->jam_selesai,0,5) : '16:00') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Kuota / Hari</label>
        <input type="number" name="kuota" class="form-control" min="1" value="{{ old('kuota', $jadwal->kuota ?? 50) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Harga Tiket</label>
        <input type="number" name="harga_tiket" class="form-control" min="0" value="{{ old('harga_tiket', $jadwal->harga_tiket ?? 15000) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="aktif" {{ (old('status', $jadwal->status ?? 'aktif') === 'aktif') ? 'selected' : '' }}>Aktif</option>
            <option value="tidak_aktif" {{ (old('status', $jadwal->status ?? '') === 'tidak_aktif') ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>
</div>
<div class="mt-4"></div>
