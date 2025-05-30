@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Header dengan Status -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $pengaduan->judul }}</h1>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @switch($pengaduan->status->nama)
                    @case('Pending')
                        bg-yellow-100 text-yellow-800
                        @break
                    @case('Diproses')
                        bg-blue-100 text-blue-800
                        @break
                    @case('Selesai')
                        bg-green-100 text-green-800
                        @break
                    @default
                        bg-gray-100 text-gray-800
                @endswitch
            ">
                {{ $pengaduan->status->nama }}
            </span>
        </div>

        <!-- Informasi Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Detail Pengaduan</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-600">Kategori:</span>
                        <span class="font-medium">{{ $pengaduan->kategori->nama }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Lokasi:</span>
                        <span class="font-medium">{{ $pengaduan->lokasi }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Tingkat Urgensi:</span>
                        <span class="font-medium 
                            @switch($pengaduan->urgensi)
                                @case('rendah')
                                    text-green-600
                                    @break
                                @case('sedang')
                                    text-yellow-600
                                    @break
                                @case('tinggi')
                                    text-orange-600
                                    @break
                                @case('kritis')
                                    text-red-600
                                    @break
                            @endswitch
                        ">
                            {{ ucfirst($pengaduan->urgensi) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Pengaju</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-600">Nama:</span>
                        <span class="font-medium">{{ $pengaduan->mahasiswa->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Tanggal Pengaduan:</span>
                        <span class="font-medium">{{ $pengaduan->tanggal_pengaduan->format('d F Y') }}</span>
                    </div>
                    @if($pengaduan->tanggal_selesai)
                    <div>
                        <span class="text-gray-600">Tanggal Selesai:</span>
                        <span class="font-medium">{{ $pengaduan->tanggal_selesai->format('d F Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Deskripsi Pengaduan</h2>
            <p class="text-gray-600 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
        </div>

        <!-- Bukti -->
        @if($pengaduan->bukti_path)
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Bukti Pendukung</h2>
            <div class="mt-2">
                <img src="{{ asset('storage/' . $pengaduan->bukti_path) }}" 
                     alt="Bukti Pengaduan" 
                     class="max-w-lg rounded-lg shadow">
            </div>
        </div>
        @endif

        <!-- Tombol Aksi -->
        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('pengajuan.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
            
            @if(auth()->user()->role === 'admin' || auth()->user()->id === $pengaduan->mahasiswa_id)
            <div class="flex space-x-2">
                <a href="{{ route('pengajuan.edit', $pengaduan->id) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                
                <form action="{{ route('pengajuan.destroy', $pengaduan->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                        Hapus
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 