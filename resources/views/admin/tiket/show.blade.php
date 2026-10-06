@extends('layouts.admin')

@section('title', 'Detail Tiket')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header">

        Detail Tiket

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">Kode Tiket</th>
                <td>{{ $tiket->kode_tiket }}</td>
            </tr>

            <tr>
                <th>Kode Reservasi</th>
                <td>{{ $tiket->reservasi->kode_reservasi }}</td>
            </tr>

            <tr>
                <th>Pengunjung</th>
                <td>{{ $tiket->reservasi->user->name }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ $tiket->status }}</td>
            </tr>

            <tr>
                <th>QR Code</th>
                <td>

                    @if($tiket->qr_code)

                        <img
                            src="{{ asset('qr-code/'.$tiket->qr_code) }}"
                            width="200">

                    @else

                        Belum tersedia

                    @endif

                </td>
            </tr>

        </table>

        <div class="mt-3">

            @if($tiket->status == 'Aktif')

                <form action="{{ route('admin.tiket.gunakan',$tiket->id) }}"
                      method="POST"
                      class="d-inline">

                    @csrf
                    @method('PUT')

                    <button class="btn btn-success">

                        Tandai Digunakan

                    </button>

                </form>

            @endif

            <a href="{{ route('admin.tiket.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </div>

</div>

@endsection