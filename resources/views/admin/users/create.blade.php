@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('content')
<div class="card shadow-sm"><div class="card-body p-4">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        @include('admin.users._form')
        <button class="btn btn-warning fw-semibold">Simpan</button>
    </form>
</div></div>
@endsection
