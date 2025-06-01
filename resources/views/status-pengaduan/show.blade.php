@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Status Pengaduan</h2>

    <div class="mb-3">
        <strong>ID:</strong> {{ $statusPengaduan->id }}
    </div>
    <div class="mb-3">
        <strong>Nama:</strong> {{ $statusPengaduan->nama }}
    </div>

    <a href="{{ route('status-pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
