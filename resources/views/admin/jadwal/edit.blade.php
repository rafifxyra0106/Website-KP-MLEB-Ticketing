@extends('layouts.admin')

@section('title', 'Edit Jadwal')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header">

        <h5 class="mb-0">
            Edit Jadwal Kunjungan
        </h5>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Hari Operasional
                    </label>

                    <select name="hari_operasional"
                            class="form-select"
                            required>

                        <option value="Senin"
                            {{ $jadwal->hari_operasional == 'Senin' ? 'selected' : '' }}>
                            Senin
                        </option>

                        <option value="Selasa"
                            {{ $jadwal->hari_operasional == 'Selasa' ? 'selected' : '' }}>
                            Selasa
                        </option>

                        <option value="Rabu"
                            {{ $jadwal->hari_operasional == 'Rabu' ? 'selected' : '' }}>
                            Rabu
                        </option>

                        <option value="Kamis"
                            {{ $jadwal->hari_operasional == 'Kamis' ? 'selected' : '' }}>
                            Kamis
                        </option>

                        <option value="Jumat"
                            {{ $jadwal->hari_operasional == 'Jumat' ? 'selected' : '' }}>
                            Jumat
                        </option>

                        <option value="Sabtu"
                            {{ $jadwal->hari_operasional == 'Sabtu' ? 'selected' : '' }}>
                            Sabtu
                        </option>

                        <option value="Minggu"
                            {{ $jadwal->hari_operasional == 'Minggu' ? 'selected' : '' }}>
                            Minggu
                        </option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Jam Buka
                    </label>

                    <input type="time"
                           name="jam_buka"
                           value="{{ $jadwal->jam_buka }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Jam Tutup
                    </label>

                    <input type="time"
                           name="jam_tutup"
                           value="{{ $jadwal->jam_tutup }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Kuota Harian
                    </label>

                    <input type="number"
                           name="kuota_harian"
                           value="{{ $jadwal->kuota_harian }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Harga Tiket
                    </label>

                    <input type="number"
                           name="harga_tiket"
                           value="{{ $jadwal->harga_tiket }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-select"
                            required>

                        <option value="buka"
                            {{ $jadwal->status == 'buka' ? 'selected' : '' }}>
                            Buka
                        </option>

                        <option value="tutup"
                            {{ $jadwal->status == 'tutup' ? 'selected' : '' }}>
                            Tutup
                        </option>

                    </select>

                </div>

            </div>

            <div class="mt-3">

                <button type="submit"
                        class="btn btn-success">

                    <i class="fas fa-save"></i>
                    Update Jadwal

                </button>

                <a href="{{ route('admin.jadwal.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection