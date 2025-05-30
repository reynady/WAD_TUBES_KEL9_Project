@extends('layouts.app')

@section('title', 'Daftar Pengaduan Fasilitas')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">
            <i class="fas fa-list-check me-2"></i>Daftar Pengaduan
        </h1>
        @can('create', App\Models\Pengaduan::class)
            <a href="{{ route('pengaduan.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Buat Baru
            </a>
        @endcan
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>Filter Pengaduan
            </h5>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#filterCollapse">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div class="collapse show" id="filterCollapse">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Pencarian</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" id="search" 
                                   placeholder="Cari judul atau deskripsi..." value="{{ request('search') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="">Semua Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" id="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach($kategories as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th>Judul</th>
                            <th width="120">Kategori</th>
                            <th width="120">Status</th>
                            <th width="150">Tanggal</th>
                            <th width="120">Urgensi</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengaduan as $item)
                            <tr>
                                <td>#{{ $item->id }}</td>
                                <td>
                                    <a href="{{ route('pengaduan.show', $item->id) }}" class="text-decoration-none">
                                        {{ Str::limit($item->judul, 40) }}
                                    </a>
                                    <div class="text-muted small">
                                        {{ Str::limit($item->deskripsi, 50) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        {{ $item->kategori->nama }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->status_id == 1) 
                                        <span class="badge bg-warning bg-opacity-15 text-warning">
                                            <i class="fas fa-clock me-1"></i>{{ $item->status->nama }}
                                        </span>
                                    @elseif($item->status_id == 2) 
                                        <span class="badge bg-primary bg-opacity-15 text-primary">
                                            <i class="fas fa-cog me-1"></i>{{ $item->status->nama }}
                                        </span>
                                    @elseif($item->status_id == 3) 
                                        <span class="badge bg-success bg-opacity-15 text-success">
                                            <i class="fas fa-check-circle me-1"></i>{{ $item->status->nama }}
                                        </span>
                                    @else 
                                        <span class="badge bg-danger bg-opacity-15 text-danger">
                                            <i class="fas fa-times-circle me-1"></i>{{ $item->status->nama }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-block">{{ $item->tanggal_pengaduan->format('d M Y') }}</span>
                                    <small class="text-muted">{{ $item->tanggal_pengaduan->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($item->urgensi == 'rendah')
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            <i class="fas fa-arrow-down me-1"></i>Rendah
                                        </span>
                                    @elseif($item->urgensi == 'sedang')
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            <i class="fas fa-equals me-1"></i>Sedang
                                        </span>
                                    @elseif($item->urgensi == 'tinggi')
                                        <span class="badge bg-warning bg-opacity-15 text-warning">
                                            <i class="fas fa-arrow-up me-1"></i>Tinggi
                                        </span>
                                    @else 
                                        <span class="badge bg-danger bg-opacity-15 text-danger">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Kritis
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('pengaduan.show', $item->id) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($item->bisaDiedit())
                                            <a href="{{ route('pengaduan.edit', $item->id) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if($item->bisaDihapus())
                                            <form action="{{ route('pengaduan.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        title="Hapus" onclick="return confirm('Hapus pengaduan ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Tidak ada data pengaduan</h5>
                                        @can('create', App\Models\Pengaduan::class)
                                            <a href="{{ route('pengaduan.create') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-plus-circle me-2"></i>Buat Pengaduan
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($pengaduan->hasPages())
                <div class="card-footer bg-white">
                    {{ $pengaduan->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('status').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('kategori').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endpush