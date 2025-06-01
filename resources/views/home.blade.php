@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('images/telkom-university-logo.png') }}" alt="Telkom University Logo" class="h-12">
                    <h1 class="text-2xl font-bold">Sistem Pengaduan Fasilitas Kampus</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="font-medium">{{ auth()->user()->name }}</span>
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition duration-300">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
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
                           class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg flex items-center transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Buat Pengaduan Baru
                        </a>
                    @endif
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    @if(auth()->user()->role === 'admin')
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                            <h3 class="text-gray-500 font-medium">Total Pengaduan</h3>
                            <p class="text-3xl font-bold">1,248</p>
                            <p class="text-sm text-gray-400">+12% dari bulan lalu</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                            <h3 class="text-gray-500 font-medium">Dalam Proses</h3>
                            <p class="text-3xl font-bold">324</p>
                            <p class="text-sm text-gray-400">5 hari rata-rata penanganan</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                            <h3 class="text-gray-500 font-medium">Selesai</h3>
                            <p class="text-3xl font-bold">876</p>
                            <p class="text-sm text-gray-400">70% resolusi</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                            <h3 class="text-gray-500 font-medium">Ditolak</h3>
                            <p class="text-3xl font-bold">48</p>
                            <p class="text-sm text-gray-400">4% dari total</p>
                        </div>
                    @else
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                            <h3 class="text-gray-500 font-medium">Pengaduan Anda</h3>
                            <p class="text-3xl font-bold">12</p>
                            <p class="text-sm text-gray-400">Total pengaduan</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                            <h3 class="text-gray-500 font-medium">Dalam Proses</h3>
                            <p class="text-3xl font-bold">3</p>
                            <p class="text-sm text-gray-400">Sedang ditindaklanjuti</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                            <h3 class="text-gray-500 font-medium">Selesai</h3>
                            <p class="text-3xl font-bold">8</p>
                            <p class="text-sm text-gray-400">Telah diselesaikan</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                            <h3 class="text-gray-500 font-medium">Ditolak</h3>
                            <p class="text-3xl font-bold">1</p>
                            <p class="text-sm text-gray-400">Tidak memenuhi syarat</p>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">
                        @if(auth()->user()->role === 'admin')
                            Pengaduan Terbaru
                        @else
                            Riwayat Pengaduan Anda
                        @endif
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pengaduan as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($item->content, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('pengaduan.show', $item->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                                        @if(auth()->user()->role === 'mahasiswa' && $item->status === 'Menunggu')
                                            <a href="{{ route('pengaduan.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
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

            @if(auth()->user()->role === 'admin')
                <!-- Admin Only Section -->
                <section class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Manajemen Laporan</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quick Stats -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Statistik Pengaduan</h3>
                            <canvas id="pengaduanChart" height="200"></canvas>
                        </div>
                        
                        <!-- Recent Reports -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-800">Laporan Terakhir</h3>
                                <a href="{{ route('laporan.create') }}" class="text-blue-600 hover:text-blue-800 text-sm">Buat Baru</a>
                            </div>
                            
                            <ul class="space-y-3">
                                @foreach($laporan ?? [] as $report)
                                <li class="border-b pb-2">
                                    <a href="{{ route('laporan.show', $report->id) }}" class="block hover:bg-gray-50 p-2 rounded">
                                        <div class="flex justify-between">
                                            <span class="font-medium">{{ $report->judul_laporan }}</span>
                                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($report->periode_awal)->format('d M') }} - {{ \Carbon\Carbon::parse($report->periode_akhir)->format('d M Y') }}</span>
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $report->total_pengaduan }} pengaduan</div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </section>
            @endif
        @else
            <!-- Guest Welcome Section -->
            <section class="text-center py-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-6">Sistem Pengaduan Fasilitas Telkom University</h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Platform untuk melaporkan dan memantau keluhan fasilitas kampus secara transparan dan efisien.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition duration-300">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-8 py-3 rounded-lg text-lg font-medium transition duration-300">
                        Register
                    </a>
                </div>
            </section>

            <!-- Features Section -->
            <section class="py-12 bg-gray-100 rounded-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">Fitur Utama</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="flex justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Ajukan Pengaduan</h3>
                            <p class="text-gray-600">
                                Laporkan fasilitas kampus yang bermasalah dengan mudah melalui platform digital.
                            </p>
                        </div>
                        
                        <!-- Feature 2 -->
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="flex justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Lacak Status</h3>
                            <p class="text-gray-600">
                                Pantau perkembangan pengaduan Anda secara real-time dari mana saja.
                            </p>
                        </div>
                        
                        <!-- Feature 3 -->
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="flex justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Transparansi</h3>
                            <p class="text-gray-600">
                                Sistem yang transparan memastikan setiap pengaduan mendapat respon tepat waktu.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        @endauth
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-bold">Telkom University</h3>
                    <p class="text-gray-400">Sistem Pengaduan Fasilitas Kampus</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-blue-400">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-blue-400">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-blue-400">Kontak</a>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-6 pt-6 text-center text-gray-400 text-sm">
                &copy; 2025 Telkom University. All rights reserved.
            </div>
        </div>
    </footer>
</div>

@auth
    @if(auth()->user()->role === 'admin')
        <!-- Chart Script -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('pengaduanChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                        datasets: [{
                            label: 'Pengaduan Masuk',
                            data: [120, 190, 170, 200, 180, 150],
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Pengaduan Selesai',
                            data: [80, 150, 140, 170, 160, 120],
                            backgroundColor: 'rgba(16, 185, 129, 0.5)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endauth
@endsection