
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- HERO SECTION --}}
<section class="bg-[#F5FEFF]">
    <div class="max-w-7xl mx-auto px-6 py-16 md:py-24">
        <div class="grid md:grid-cols-2 gap-10 items-center">

            <div>
                <p class="text-[#0E2F76] font-semibold tracking-widest text-sm mb-4">
                    LITTLE MOMENT, BIG MEMORIES
                </p>

                <h1 class="text-4xl md:text-5xl font-bold text-[#0E2F76] leading-tight">
                    Abadikan Momen,
                    Ciptakan Kenangan.
                </h1>

                <p class="text-gray-600 mt-5 leading-relaxed">
                    Temukan pengalaman foto terbaik bersama TeraStudio.
                    Pilih paket favoritmu dan abadikan setiap momen spesial.
                </p>

                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="{{ route('packages') }}"
                       class="bg-[#0E2F76] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#AAC0E1] hover:text-[#0E2F76] transition">
                        Lihat Katalog
                    </a>

                    @guest
                        <a href="{{ route('register') }}"
                           class="border-2 border-[#0E2F76] text-[#0E2F76] px-6 py-3 rounded-xl font-semibold hover:bg-[#AAC0E1] transition">
                            Daftar Sekarang
                        </a>
                    @endguest
                </div>
            </div>

            <div class="bg-[#AAC0E1] rounded-3xl p-8 md:p-12 text-center">
                <div class="bg-white rounded-2xl p-10 shadow-sm">
                    <p class="text-5xl mb-4">📸</p>
                    <h2 class="text-2xl font-bold text-[#0E2F76]">
                        Your Story, Your Memories
                    </h2>
                    <p class="text-gray-500 mt-3 text-sm">
                        Every picture has a story to tell.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- REKOMENDASI CBF --}}
<section class="max-w-7xl mx-auto px-6 py-16">

    <div class="mb-8">
        <p class="text-[#0E2F76] font-semibold tracking-widest text-sm">
            CONTENT-BASED FILTERING
        </p>

        <h2 class="text-3xl font-bold text-[#0E2F76] mt-2">
            Rekomendasi Untukmu
        </h2>

        <p class="text-gray-500 mt-2">
            Temukan paket yang sesuai dengan preferensi dan riwayat bookingmu.
        </p>
    </div>

    @auth

        @if ($customer)

            <div class="bg-[#F5FEFF] border border-[#AAC0E1] rounded-2xl p-5 mb-8">
                <p class="text-gray-600 text-sm">
                    Selamat datang kembali,
                </p>

                <h3 class="text-xl font-bold text-[#0E2F76]">
                    {{ $customer->nama }}!
                </h3>
            </div>

            @if ($hasHistory)

                @if (count($recommendations) > 0)

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        @foreach ($recommendations as $package)

                            <div class="bg-white rounded-2xl border border-[#AAC0E1] p-6 hover:shadow-lg transition">

                                <span class="inline-block bg-[#F5FEFF] text-[#0E2F76] text-sm font-semibold px-3 py-1 rounded-full">
                                    {{ $package->kategori_layanan }}
                                </span>

                                <h3 class="text-lg font-bold text-[#0E2F76] mt-4">
                                    {{ $package->nama_paket }}
                                </h3>

                                <p class="text-gray-500 text-sm mt-2 min-h-12">
                                    {{ $package->deskripsi }}
                                </p>

                                <p class="text-xl font-bold text-[#0E2F76] mt-5">
                                    Rp{{ number_format($package->harga, 0, ',', '.') }}
                                </p>

                                <div class="border-t border-[#AAC0E1] mt-5 pt-4">
                                    <p class="text-gray-500 text-sm">
                                        Tingkat Kemiripan
                                    </p>

                                    <p class="text-lg font-bold text-[#0E2F76]">
                                        {{ $package->similarity_score }}%
                                    </p>
                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="bg-[#F5FEFF] border border-[#AAC0E1] rounded-2xl p-8 text-center">
                        <h3 class="text-lg font-bold text-[#0E2F76]">
                            Belum Ada Rekomendasi
                        </h3>

                        <p class="text-gray-500 mt-2">
                            Sistem belum menemukan paket yang cukup mirip
                            dengan riwayat booking kamu.
                        </p>
                    </div>

                @endif

            @else

                <div class="bg-[#F5FEFF] border border-[#AAC0E1] rounded-2xl p-8 text-center">
                    <p class="text-4xl mb-3">✨</p>

                    <h3 class="text-lg font-bold text-[#0E2F76]">
                        Mulai Temukan Paket Favoritmu!
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Kamu belum memiliki riwayat booking.
                        Lakukan booking pertama agar sistem dapat
                        mempelajari preferensimu dan memberikan rekomendasi.
                    </p>

                    <a href="{{ route('packages') }}"
                       class="inline-block mt-5 bg-[#0E2F76] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#AAC0E1] hover:text-[#0E2F76] transition">
                        Jelajahi Paket
                    </a>
                </div>

            @endif

        @else

            <div class="bg-[#F5FEFF] border border-[#AAC0E1] rounded-2xl p-8 text-center">
                <h3 class="text-lg font-bold text-[#0E2F76]">
                    Akun belum terhubung dengan data pelanggan
                </h3>

                <p class="text-gray-500 mt-2">
                    Silakan periksa kembali data akun pelanggan.
                </p>
            </div>

        @endif

    @else

        <div class="bg-[#F5FEFF] border border-[#AAC0E1] rounded-2xl p-8 text-center">
            <p class="text-4xl mb-3">💙</p>

            <h3 class="text-xl font-bold text-[#0E2F76]">
                Rekomendasi Personal Menantimu!
            </h3>

            <p class="text-gray-500 mt-2">
                Login untuk melihat rekomendasi paket berdasarkan
                riwayat booking dan preferensimu.
            </p>

            <div class="flex justify-center gap-3 mt-6">
                <a href="{{ route('login') }}"
                   class="bg-[#0E2F76] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#AAC0E1] hover:text-[#0E2F76] transition">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="border border-[#0E2F76] text-[#0E2F76] px-6 py-3 rounded-xl font-semibold hover:bg-[#AAC0E1] transition">
                    Daftar
                </a>
            </div>
        </div>

    @endauth

</section>


{{-- KATALOG PILIHAN --}}
<section class="bg-[#F5FEFF] py-16">

    <div class="max-w-7xl mx-auto px-6">

        <div class="flex flex-wrap justify-between items-end gap-4 mb-8">

            <div>
                <p class="text-[#0E2F76] font-semibold tracking-widest text-sm">
                    OUR PACKAGES
                </p>

                <h2 class="text-3xl font-bold text-[#0E2F76] mt-2">
                    Pilihan Paket
                </h2>

                <p class="text-gray-500 mt-2">
                    Pilih paket foto yang sesuai dengan momenmu.
                </p>
            </div>

            <a href="{{ route('packages') }}"
               class="text-[#0E2F76] font-semibold hover:underline">
                Lihat Semua Paket →
            </a>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($packages as $package)

                <div class="bg-white rounded-2xl border border-[#AAC0E1] p-6 hover:shadow-lg transition">

                    <span class="inline-block bg-[#F5FEFF] text-[#0E2F76] text-sm font-semibold px-3 py-1 rounded-full">
                        {{ $package->kategori_layanan }}
                    </span>

                    <h3 class="text-lg font-bold text-[#0E2F76] mt-4">
                        {{ $package->nama_paket }}
                    </h3>

                    <p class="text-gray-500 text-sm mt-2 min-h-12">
                        {{ $package->deskripsi }}
                    </p>

                    <p class="text-xl font-bold text-[#0E2F76] mt-5">
                        Rp{{ number_format($package->harga, 0, ',', '.') }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection
