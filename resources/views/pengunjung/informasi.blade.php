@extends('layouts.app')
@section('title','Informasi Museum')
@section('content')
<div class="page-header"><div class="container"><h1><i class="bi bi-info-circle me-2"></i>Informasi Museum</h1><p class="mb-0">Kenali lebih dekat Museum Listrik dan Energi Baru</p></div></div>
<section class="py-4"><div class="container">
<div class="row g-4">
@forelse($informasi as $info)
<div class="col-md-6 col-lg-4">
    <div class="card-mleb card h-100">
        @if($info->gambar && file_exists(public_path('images/informasi/'.$info->gambar)))
        <img src="{{ $info->gambar_url }}" class="card-img-top" style="height:200px;object-fit:cover" alt="{{ $info->judul }}">
        @else
        <div style="height:160px;background:linear-gradient(135deg,var(--mleb-primary),#1a5276);display:flex;align-items:center;justify-content:center;font-size:3rem">⚡</div>
        @endif
        <div class="card-body d-flex flex-column">
            <h5 class="fw-bold mb-2">{{ $info->judul }}</h5>
            <p class="text-muted small flex-grow-1">{{ Str::limit($info->deskripsi, 130) }}</p>
            <a href="{{ route('informasi.show',$info->id) }}" class="btn btn-outline-primary btn-sm mt-2">Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center py-5 text-muted"><i class="bi bi-info-circle fs-1 d-block mb-2"></i>Belum ada informasi tersedia.</div>
@endforelse
</div>
</div></section>
@endsection
