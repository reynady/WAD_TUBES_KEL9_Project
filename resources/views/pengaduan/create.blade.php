@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Pengaduan Baru</h1>

            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Judul Pengaduan -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Pengaduan
                    </label>
                    <input type="text" name="title" id="title" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                        placeholder="Masukkan judul pengaduan">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori
                    </label>
                    <select name="kategori" id="kategori" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Pilih Kategori</option>
                        <option value="Fasilitas Kelas">Fasilitas Kelas</option>
                        <option value="Laboratorium">Laboratorium</option>
                        <option value="Toilet">Toilet</option>
                        <option value="Parkir">Parkir</option>
                        <option value="Kantin">Kantin</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('kategori')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="mb-6">
                    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi
                    </label>
                    <input type="text" name="lokasi" id="lokasi" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                        placeholder="Masukkan lokasi detail">
                    @error('lokasi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Pengaduan
                    </label>
                    <textarea name="content" id="content" rows="5" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                        placeholder="Jelaskan detail pengaduan Anda"></textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Lampiran Gambar
                    </label>
                    <input type="file" name="image" id="image" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        accept="image/*"
                        onchange="previewImage(event)">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF (Max. 2MB)</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="preview" class="max-w-xs rounded-lg shadow-md">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">
                        Kembali
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        Kirim Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');

    reader.onload = function() {
        preview.src = reader.result;
        imagePreview.classList.remove('hidden');
    }

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    } else {
        imagePreview.classList.add('hidden');
    }
}
</script>
@endsection 