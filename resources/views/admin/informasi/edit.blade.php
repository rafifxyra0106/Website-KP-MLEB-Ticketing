@extends('layouts.admin')

@section('title', 'Edit Informasi')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header">

        Edit Informasi Museum

    </div>

    <div class="card-body">

        <form action="{{ route('admin.informasi.update',$informasi->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label>Judul</label>

                <input type="text"
                       name="judul"
                       value="{{ $informasi->judul }}"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Gambar Saat Ini</label>

                <br>

                <img
                    src="{{ asset('images/'.$informasi->gambar) }}"
                    onerror="this.src='{{ asset('images/placeholder.jpg') }}'"
                    width="200">

            </div>

            <div class="mb-3">

                <label>Ganti Gambar</label>

                <input type="file"
                       name="gambar"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Deskripsi</label>

                <textarea name="deskripsi"
                          rows="8"
                          class="form-control">{{ $informasi->deskripsi }}</textarea>

            </div>

            <button class="btn btn-success">

                Update

            </button>

        </form>

    </div>

</div>

@endsection