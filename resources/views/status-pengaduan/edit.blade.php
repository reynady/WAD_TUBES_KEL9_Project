@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Status Pengaduan</h2>

    <form action="{{ route('status-pengaduan.update', $statusPengaduan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Status</label>
            <input type="text" name="nama" class="form-control" value="{{ $statusPengaduan->nama }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('status-pengaduan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
