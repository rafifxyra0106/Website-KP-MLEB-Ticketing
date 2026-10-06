@extends('layouts.admin')

@section('title', 'Tambah Jadwal')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header">

        Tambah Jadwal Kunjungan

    </div>

    <div class="card-body">

        <form action="{{ route('admin.jadwal.store') }}"
              method="POST">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Hari Operasional</label>

                    <select name="hari_operasional"
                            class="form-select">

                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                        <option>Minggu</option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label>Jam Buka</label>

                    <input type="time"
                           name="jam_buka"
                           class="form-control">

                </div>

                <div class="col-md-3 mb-3">

                    <label>Jam Tutup</label>

                    <input type="time"
                           name="jam_tutup"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Kuota Harian</label>

                    <input type="number"
                           name="kuota_harian"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Harga Tiket</label>

                    <input type="number"
                           name="harga_tiket"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Status</label>

                    <select name="status"
                            class="form-select">

                        <option value="buka">
                            Buka
                        </option>

                        <option value="tutup">
                            Tutup
                        </option>

                    </select>

                </div>

            </div>

            <button class="btn btn-primary">

                Simpan

            </button>

        </form>

    </div>

</div>

@endsection