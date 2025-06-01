@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Status Pengaduan</h2>
    <a href="{{ route('status-pengaduan.create') }}" class="btn btn-primary mb-3">Tambah Status</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statusPengaduan as $status)
            <tr>
                <td>{{ $status->id }}</td>
                <td>{{ $status->nama }}</td>
                <td>
                    <a href="{{ route('status-pengaduan.show', $status->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('status-pengaduan.edit', $status->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('status-pengaduan.destroy', $status->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
