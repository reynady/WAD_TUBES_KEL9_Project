@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Status Pengaduan</h2>

    <form action="{{ route('status-pengaduan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Status</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('status-pengaduan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
