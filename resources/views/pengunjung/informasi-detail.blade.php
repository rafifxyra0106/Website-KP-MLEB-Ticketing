@extends('layouts.app')
@section('title',$info->judul)
@section('content')
<div class="page-header"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb mb-1"><li class="breadcrumb-item"><a href="{{ route('beranda') }}" class="text-white-50">Beranda</a></li><li class="breadcrumb-item"><a href="{{ route('informasi') }}" class="text-white-50">Informasi</a></li><li class="breadcrumb-item text-white active">{{ $info->judul }}</li></ol></nav><h1>{{ $info->judul }}</h1></div></div>
<section class="py-4"><div class="container" style="max-width:860px">
@if($info->gambar && file_exists(public_path('images/informasi/'.$info->gambar)))
<img src="{{ $info->gambar_url }}" alt="{{ $info->judul }}" class="w-100 rounded-3 mb-4" style="max-height:420px;object-fit:cover">
@endif
<div class="card-mleb card"><div class="card-body p-4" style="line-height:1.9;font-size:.95rem">{!! nl2br(e($info->deskripsi)) !!}</div></div>
<div class="mt-3 d-flex gap-2">
    <a href="{{ route('informasi') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
    <a href="{{ route('reservasi.create') }}" class="btn btn-mleb"><i class="bi bi-ticket-perforated me-2"></i>Pesan Tiket</a>
</div>
</div></section>
@endsection
