@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold">Sistem Pengaduan</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="font-medium">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:underline">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        @auth
            <!-- Dashboard Section -->
            <section class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                    
                    @if(auth()->user()->role === 'mahasiswa')
                        <a href="{{ route('pengaduan.create') }}" 
                           class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg">
                            Buat Pengaduan
                        </a>
                    @endif
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                        <h3 class="text-gray-500 font-medium">Total Pengaduan</h3>
                        <p class="text-3xl font-bold">{{ $totalPengaduan ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                        <h3 class="text-gray-500 font-medium">Dalam Proses</h3>
                        <p class="text-3xl font-bold">{{ $dalamProses ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                        <h3 class="text-gray-500 font-medium">Selesai</h3>
                        <p class="text-3xl font-bold">{{ $selesai ?? 0 }}</p>
                    </div>
                </div>

                <!-- Daftar Pengaduan -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">
                        @if(auth()->user()->role === 'admin')
                            Daftar Pengaduan
                        @else
                            Pengaduan Anda
                        @endif
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pengaduan as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($item->content, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColor = [
                                                'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                                'Diproses' => 'bg-blue-100 text-blue-800',
                                                'Selesai' => 'bg-green-100 text-green-800',
                                                'Ditolak' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor[$item->status] }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="{{ route('pengaduan.show', $item->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                                        @if(auth()->user()->role === 'mahasiswa' && $item->status === 'Menunggu')
                                            <a href="{{ route('pengaduan.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada pengaduan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $pengaduan->links() }}
                    </div>
                </div>
            </section>
        @else
            <!-- Welcome Section -->
            <section class="text-center py-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-6">Sistem Pengaduan Fasilitas</h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Platform untuk melaporkan dan memantau keluhan fasilitas kampus.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-8 py-3 rounded-lg text-lg font-medium">
                        Register
                    </a>
                </div>
            </section>
        @endif
    </main>
</div>
@endsection