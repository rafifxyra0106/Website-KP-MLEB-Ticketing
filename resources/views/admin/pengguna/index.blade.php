@extends('layouts.admin')

@section('title', 'Data Pengguna')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header">

        Data Pengguna

    </div>

    <div class="card-body">

        <table id="dataTable"
               class="table table-bordered table-striped">

            <thead>

            <tr>

                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>

            </tr>

            </thead>

            <tbody>

            @foreach($users as $user)

                <tr>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ ucfirst($user->role) }}</td>

                    <td>

                        <a href="{{ route('admin.pengguna.show',$user->id) }}"
                           class="btn btn-info btn-sm">

                            Detail

                        </a>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@push('scripts')

<script>

$(document).ready(function(){
    $('#dataTable').DataTable();
});

</script>

@endpush

@endsection