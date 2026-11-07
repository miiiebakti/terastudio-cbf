
@extends('layouts.app')

@section('title', 'Katalog Paket')

@section('content')

<section class="max-w-7xl mx-auto px-5 sm:px-6 py-12">

    <!-- Header -->
    <div class="text-center mb-10">
        <p class="text-sm font-bold tracking-widest text-[#AAC0E1]">
            TERASTUDIO
        </p>

        <h1 class="text-3xl md:text-4xl font-extrabold text-[#0E2F76] mt-3">
            Find Your Perfect Moment
        </h1>

        <p class="text-gray-500 mt-3 text-sm md:text-base">
            Pilih paket foto yang paling sesuai untuk mengabadikan momenmu.
        </p>
    </div>

    @php
        $groupedPackages = $packages->groupBy('kategori_layanan');
    @endphp

    <!-- Navigasi Kategori -->
    <div class="flex justify-center gap-3 overflow-x-auto pb-5 mb-8">
        @foreach ($groupedPackages as $category => $items)
            <a href="#kategori-{{ \Illuminate\Support\Str::slug($category) }}"
               class="shrink-0 bg-[#0E2F76] text-white text-xs sm:text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-[#AAC0E1] transition">
                {{ $category }}
            </a>
        @endforeach
    </div>

    <!-- Daftar Paket per Kategori -->
    @foreach ($groupedPackages as $category => $items)

        @php
            $categoryId = \Illuminate\Support\Str::slug($category);
            $isPhotobox = str_contains(strtolower($category), 'photobox');
        @endphp

        <div id="kategori-{{ $categoryId }}" class="mb-14 scroll-mt-28">

            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-[#0E2F76]">
                        {{ $category }} Packages
                    </h2>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ $items->count() }} pilihan paket tersedia
                    </p>
                </div>

                <span class="text-xs text-[#0E2F76] hidden sm:block">
                    Geser untuk melihat lainnya →
                </span>
            </div>

            <!-- Horizontal Scroll -->
            <div class="flex gap-5 overflow-x-auto pb-6 snap-x snap-mandatory">

                @foreach ($items as $package)

                    <article class="bg-white border border-[#AAC0E1]/40 rounded-2xl shadow-sm hover:shadow-lg transition overflow-hidden shrink-0 w-[245px] sm:w-[270px] snap-start">

                        <!-- Visual Paket -->
                        <div class="h-40 flex items-center justify-center
                            {{ $isPhotobox
                                ? 'bg-gradient-to-br from-[#AAC0E1] via-[#D8E8F5] to-[#F5FEFF]'
                                : 'bg-gradient-to-br from-[#D8F5F8] via-[#AAC0E1] to-[#F5FEFF]' }}">

                            <div class="text-center">
                                <div class="text-5xl mb-2">
                                    {{ $isPhotobox ? '📸' : '🪞' }}
                                </div>

                                <p class="text-[#0E2F76] font-bold text-sm">
                                    {{ $category }}
                                </p>
                            </div>
                        </div>

                        <!-- Informasi Paket -->
                        <div class="p-5">

                            <h3 class="text-base font-bold text-[#0E2F76] mb-3">
                                {{ $package->nama_paket }}
                            </h3>

                            <p class="text-gray-500 text-xs leading-6 min-h-[72px] line-clamp-4">
                                {{ $package->deskripsi }}
                            </p>

                            <div class="border-t border-gray-100 mt-4 pt-4">

                                <p class="text-xs text-gray-400 mb-1">
                                    Harga paket
                                </p>

                                <p class="text-lg font-extrabold text-[#0E2F76]">
                                    Rp{{ number_format($package->harga, 0, ',', '.') }}
                                </p>

                            </div>

                            <a href="{{ route('booking.create', $package->id) }}"
                                class="block w-full mt-4 bg-[#0E2F76] text-white text-center text-xs font-semibold py-3 rounded-lg hover:bg-[#AAC0E1] transition">
                                    Book Now
                                </a>

                        </div>
                    </article>

                @endforeach

            </div>
        </div>

    @endforeach

    <!-- Ajakan Booking -->
    <div class="bg-[#0E2F76] rounded-2xl p-8 md:p-10 text-center text-white mt-8">

        <h2 class="text-xl md:text-2xl font-bold">
            Ready to Capture Your Moments?
        </h2>

        <p class="text-sm text-blue-100 mt-3">
            Pilih paket favoritmu dan ciptakan kenangan bersama TeraStudio.
        </p>

        @guest
            <a href="{{ route('login') }}"
               class="inline-block mt-6 bg-white text-[#0E2F76] px-7 py-3 rounded-full text-sm font-bold hover:bg-[#AAC0E1] transition">
                Login untuk Booking
            </a>
        @else
            <p class="mt-5 text-sm text-blue-100">
                Selamat datang kembali di TeraStudio!
            </p>
        @endguest

    </div>

</section>

@endsection
