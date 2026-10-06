<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title>Invoice</title>

<style>

body{
    font-family: sans-serif;
}

table{
    width:100%;
    border-collapse: collapse;
}

table td,
table th{
    border:1px solid #000;
    padding:8px;
}

</style>

</head>
<body>

<h2>
    INVOICE PEMESANAN TIKET MLEB
</h2>

<hr>

<table>

<tr>
    <th width="250">Nomor Invoice</th>
    <td>{{ $invoice->nomor_invoice }}</td>
</tr>

<tr>
    <th>Kode Reservasi</th>
    <td>{{ $invoice->reservasi->kode_reservasi }}</td>
</tr>

<tr>
    <th>Nama Pengunjung</th>
    <td>{{ $invoice->reservasi->user->name }}</td>
</tr>

<tr>
    <th>Tanggal Kunjungan</th>
    <td>{{ $invoice->reservasi->tanggal_kunjungan }}</td>
</tr>

<tr>
    <th>Jumlah Tiket</th>
    <td>{{ $invoice->reservasi->jumlah_tiket }}</td>
</tr>

<tr>
    <th>Total Pembayaran</th>
    <td>

        Rp
        {{ number_format($invoice->reservasi->total_harga,0,',','.') }}

    </td>
</tr>

</table>

<br>

<p>

Terima kasih telah melakukan reservasi kunjungan
Museum Listrik dan Energi Baru.

</p>

</body>
</html>