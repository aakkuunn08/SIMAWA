@extends('layouts.main')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4">
        {{-- Navigasi Kembali --}}
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-orange-500 hover:text-orange-600 font-medium transition-colors mb-8 group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        
        <article class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Header Berita --}}
            <div class="p-8 md:p-12 pb-0">
                <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                    {{ $berita->judul_berita }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-10 pb-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold mr-3 uppercase">
                            {{ substr($berita->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-gray-900 font-semibold leading-none mb-1">{{ $berita->user->name }}</p>
                            <p class="text-xs">Penulis</p>
                        </div>
                    </div>
                    <span class="hidden md:block text-gray-300">|</span>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }}
                    </div>
                </div>
            </div>

            {{-- Gambar Utama --}}
            @if($berita->gambar)
                <div class="px-8 md:px-12">
                    <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" class="w-full h-auto object-cover max-h-[500px]" alt="{{ $berita->judul_berita }}">
                    </div>
                </div>
            @endif

            {{-- Konten Berita --}}
            <div class="p-8 md:p-12 prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($berita->konten)) !!}
            </div>

            {{-- NOTIFIKASI KEPEMILIKAN (Info Saja, Tanpa Tombol) --}}
            <div class="px-8 md:px-12 py-8 bg-gray-50 border-t border-gray-100 mt-4">
                @can('update', $berita)
                    {{-- Pesan untuk Owner/AdminBEM --}}
                    <div class="flex items-center gap-3 text-blue-700 bg-blue-50 p-4 rounded-2xl border border-blue-100 shadow-sm">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-medium">
                            <b>Informasi:</b> Anda adalah pemilik berita ini. Anda dapat melakukan perubahan (edit) melalui <b>Dashboard SIMAWA</b>.
                        </p>
                    </div>
                @else
                    {{-- Pesan untuk User Lain --}}
                    <div class="flex items-center gap-3 text-gray-600 bg-gray-100 p-4 rounded-2xl border border-gray-200 shadow-sm italic">
                        <svg class="w-6 h-6 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0h-2v-2m0 0V13m0 0h2m-2 0h-2m2-9a3 3 0 100 6 3 3 0 000-6zm10 11a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm">
                            Berita ini bukan karya Anda. Ingin berbagi informasi juga? Mari buat berita atau karya Anda sendiri melalui Dashboard!
                        </p>
                    </div>
                @endcan
            </div>
        </article>

        {{-- Footer --}}
        <div class="mt-12 text-center text-gray-400 text-xs tracking-widest uppercase">
            SIMAWA ITH &bull; {{ date('Y') }}
        </div>
    </div>
</div>
@endsection