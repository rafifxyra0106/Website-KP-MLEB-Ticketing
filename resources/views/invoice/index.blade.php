@extends('layouts.app')

@section('title', 'Invoice')

@section('content')

<div class="container py-5">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-primary text-white">

            Riwayat Invoice

        </div>

        <div class="card-body">

            <table id="dataTable"
                   class="table table-bordered table-striped">

                <thead>

                <tr>

                    <th>No Invoice</th>
                    <th>Kode Reservasi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>

                </tr>

                </thead>

                <tbody>

                @foreach($invoice as $item)

                    <tr>

                        <td>{{ $item->nomor_invoice }}</td>

                        <td>{{ $item->reservasi->kode_reservasi }}</td>

                        <td>{{ $item->created_at->format('d-m-Y') }}</td>

                        <td>

                            <span class="badge bg-success">
                                Dibuat
                            </span>

                        </td>

                        <td>

                            <a href="{{ route('invoice.download',$item->id) }}"
                               class="btn btn-danger btn-sm">

                                <i class="fas fa-file-pdf"></i>
                                Download PDF

                            </a>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

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