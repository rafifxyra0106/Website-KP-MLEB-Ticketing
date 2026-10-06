@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('content')
<div class="card shadow-sm"><div class="card-body p-4">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.users._form')
        <button class="btn btn-warning fw-semibold">Perbarui</button>
    </form>
</div></div>
@endsection
