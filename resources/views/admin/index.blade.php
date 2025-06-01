@extends('layouts.app')

@section('content')
@if(session('error') || session('success'))
    @php
        $type = session('error') ? 'error' : 'success';
        $message = session($type);
        $bgColor = $type === 'error' ? 'bg-red-500' : 'bg-green-500';
    @endphp

    <div class="{{ $bgColor }} text-white p-4 rounded-lg mb-6">
        {{ $message }}
    </div>
@endif

<div class="bg-white p-6 rounded shadow mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Daftar Pengaduan</h1>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-blue-800">Total</h3>
            <p class="text-2xl font-bold text-blue-600">{{ $totalPengaduan ?? 0 }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-yellow-800">Dalam Proses</h3>
            <p class="text-2xl font-bold text-yellow-600">{{ $dalamProses ?? 0 }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-green-800">Selesai</h3>
            <p class="text-2xl font-bold text-green-600">{{ $selesai ?? 0 }}</p>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded shadow">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($pengaduan as $item)
            <div class="bg-white p-4 rounded-lg border hover:shadow-md">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-40 object-cover rounded mb-4">
                @endif

                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="text-xs text-gray-500">#{{ $item->id }}</span>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $item->title }}</h2>
                    </div>
                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                </div>
                
                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($item->content, 100) }}</p>
                
                <div class="flex items-center justify-between">
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($item->status === 'Menunggu') bg-yellow-100 text-yellow-800
                        @elseif($item->status === 'Diproses') bg-blue-100 text-blue-800
                        @elseif($item->status === 'Selesai') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $item->status }}
                    </span>
                    <div class="space-x-2">
                        <a href="{{ route('pengaduan.show', $item->id) }}" class="text-blue-600 hover:underline">Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-500 py-8">
                Tidak ada pengaduan yang tersedia.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $pengaduan->links() }}
    </div>
</div>
@endsection
