@extends('layouts.main')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('dashboard') }}#lpj" class="inline-flex items-center text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Menu
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                
                <div class="p-6 border-b border-gray-100">
                    <form action="{{ route('lpj') }}" method="GET">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama kegiatan..." 
                                   class="w-full rounded-full border-2 border-orange-400 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 py-2 px-4 pl-10 text-gray-700 placeholder-gray-400"
                            >
                            <div class="absolute top-0 left-0 mt-3 ml-4 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="w-full overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kegiatan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pengupload
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($semuaLpj as $lpj)
                            <tr class="hover:bg-gray-50 transition">
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $lpj->kegiatan->nama_kegiatan ?? 'Kegiatan Tidak Ditemukan' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $lpj->kegiatan->tempat ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold mr-2">
                                            {{ substr($lpj->kegiatan->user->name ?? '?', 0, 1) }}
                                        </div>
                                        <span>
                                            {{ $lpj->kegiatan->user->name ?? 'User Tidak Diketahui' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $lpj->created_at->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        // Kita ambil status dari database
                                        $status = $lpj->status_lpj; 
                                    @endphp

                                    @if($status == 'disetujui' || $status == 'Diterima') 
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ ucfirst($status) }}
                                        </span>
                                    @elseif($status == 'revisi' || $status == 'Ditolak')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ ucfirst($status) }}
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($status) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('kegiatan.download_lpj', $lpj->id_kegiatan) }}" class="text-orange-500 hover:text-orange-600 font-bold">Download</a>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <span class="text-sm text-gray-500">
                        Total: <span class="font-bold">{{ $semuaLpj->total() }}</span> berkas LPJ
                    </span>
                    
                    <div>
                        {{ $semuaLpj->links() }} 
                        {{-- Kalau tampilannya berantakan, pakai: {{ $semuaLpj->links('pagination::simple-tailwind') }} --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection