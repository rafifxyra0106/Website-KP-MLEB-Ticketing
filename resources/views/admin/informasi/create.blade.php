@extends('layouts.admin')

@section('title', 'Tambah Informasi')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header">

        Tambah Informasi Museum

    </div>

    <div class="card-body">

        <form action="{{ route('admin.informasi.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Judul
                </label>

                <input type="text"
                       name="judul"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Gambar
                </label>

                <input type="file"
                       name="gambar"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea name="deskripsi"
                          rows="8"
                          class="form-control"
                          required></textarea>

            </div>

            <button class="btn btn-primary">

                Simpan

            </button>

            <a href="{{ route('admin.informasi.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection