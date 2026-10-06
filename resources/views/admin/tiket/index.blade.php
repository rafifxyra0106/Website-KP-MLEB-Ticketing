@extends('layouts.admin')

@section('title', 'Data Tiket')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header">

        Data Tiket Pengunjung

    </div>

    <div class="card-body">

        <table id="dataTable"
               class="table table-bordered">

            <thead>

            <tr>

                <th>Kode Tiket</th>
                <th>Reservasi</th>
                <th>Status</th>
                <th>Aksi</th>

            </tr>

            </thead>

            <tbody>

            @foreach($tiket as $item)

                <tr>

                    <td>{{ $item->kode_tiket }}</td>

                    <td>
                        {{ $item->reservasi->kode_reservasi }}
                    </td>

                    <td>

                        @if($item->status == 'Aktif')

                            <span class="badge bg-success">
                                Aktif
                            </span>

                        @elseif($item->status == 'Digunakan')

                            <span class="badge bg-primary">
                                Digunakan
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Kadaluarsa
                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('admin.tiket.show',$item->id) }}"
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