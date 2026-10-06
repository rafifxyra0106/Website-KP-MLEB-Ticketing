@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header">

        Detail Pengguna

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">Nama</th>
                <td>{{ $user->name }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>

            <tr>
                <th>Role</th>
                <td>{{ ucfirst($user->role) }}</td>
            </tr>

            <tr>
                <th>Tanggal Registrasi</th>
                <td>{{ $user->created_at }}</td>
            </tr>

        </table>

        <a href="{{ route('admin.pengguna.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

@endsection