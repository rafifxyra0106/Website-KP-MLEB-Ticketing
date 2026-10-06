<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title>Laporan Kunjungan</title>

    <style>

    body{
        font-family: Arial, sans-serif;
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    table th,
    table td{
        border:1px solid #000;
        padding:8px;
    }

    </style>

    </head>

    <body>

    <h2 align="center">

    LAPORAN KUNJUNGAN
    MUSEUM LISTRIK DAN ENERGI BARU

    </h2>

    <p>

    Periode :
    {{ $tanggalAwal }}
    s/d
    {{ $tanggalAkhir }}

    </p>

    <table>

    <thead>

    <tr>

    <th>No</th>
    <th>Kode Reservasi</th>
    <th>Pengunjung</th>
    <th>Tanggal</th>
    <th>Peserta</th>
    <th>Status</th>

    </tr>

    </thead>

    <tbody>

    @foreach($laporan as $item)

    <tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $item->kode_reservasi }}</td>

    <td>{{ $item->user->name ?? '-' }}</td>

    <td>{{ $item->tanggal_kunjungan }}</td>

    <td>{{ $item->jumlah_peserta }}</td>

    <td>{{ $item->status }}</td>

    </tr>

    @endforeach

    </tbody>

    </table>

    <br><br><br>

    <div
    style="
    width:300px;
    float:right;
    text-align:center;
    ">

    Jakarta,
    {{ date('d-m-Y') }}

    <br><br><br><br><br>

    Manager Museum

    <br><br>

    (............................)

        </div>
    </body>
</html>