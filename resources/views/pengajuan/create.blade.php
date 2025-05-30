@extends('layouts.app')

@section('title', 'Buat Pengaduan Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Form Pengaduan Fasilitas Kampus
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Harap isi form berikut dengan data yang valid dan lengkap.
                        </div>

                        <!-- Form Input -->
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" 
                                   value="{{ old('judul') }}" 
                                   placeholder="Contoh: Lampu Mati di Lab JIC" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 10 karakter</small>
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori Fasilitas <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                    id="kategori_id" name="kategori_id" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                @foreach($kategories as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi Spesifik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                   id="lokasi" name="lokasi" 
                                   value="{{ old('lokasi') }}" 
                                   placeholder="Contoh: Gedung JIC Lantai 2 Lab 203" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="urgensi" class="form-label">Tingkat Urgensi <span class="text-danger">*</span></label>
                            <select class="form-select @error('urgensi') is-invalid @enderror" 
                                    id="urgensi" name="urgensi" required>
                                <option value="" selected disabled>-- Pilih Urgensi --</option>
                                <option value="rendah" {{ old('urgensi') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="sedang" {{ old('urgensi') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="tinggi" {{ old('urgensi') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                <option value="kritis" {{ old('urgensi') == 'kritis' ? 'selected' : '' }}>Kritis</option>
                            </select>
                            @error('urgensi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" 
                                      rows="5" required
                                      placeholder="Jelaskan masalah secara detail">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 20 karakter</small>
                        </div>

                        <div class="mb-4">
                            <label for="bukti" class="form-label">Upload Bukti <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('bukti') is-invalid @enderror" 
                                   id="bukti" name="bukti" accept="image/*,.pdf" required>
                            @error('bukti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, PDF (Maks. 5MB)</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pengaduan
                            </button>
                            <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validasi client-side sederhana
    document.querySelector('form').addEventListener('submit', function(e) {
        const judul = document.getElementById('judul').value;
        const deskripsi = document.getElementById('deskripsi').value;
        
        if (judul.length < 10) {
            alert('Judul pengaduan minimal 10 karakter');
            e.preventDefault();
        }
        
        if (deskripsi.length < 20) {
            alert('Deskripsi pengaduan minimal 20 karakter');
            e.preventDefault();
        }
    });
</script>
@end