
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<section class="bg-pink-50">
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="max-w-2xl">
            <p class="text-pink-600 font-semibold mb-3">
                LITTLE MOMENT BIG MEMORIES
            </p>

            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-5">
                Abadikan Momen Berharga Bersama TeraStudio
            </h1>

            <p class="text-gray-600 mb-8">
                Temukan paket foto yang sesuai dengan kebutuhan dan
                gaya kamu bersama TeraStudio.
            </p>

            <a href="{{ route('packages') }}"
               class="inline-block bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700">
                Lihat Katalog Paket
            </a>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-14">
    <div class="flex justify-between items-center mb-8">
        <div>
            <p class="text-pink-600 font-semibold">KATALOG</p>
            <h2 class="text-3xl font-bold">Paket Pilihan</h2>
        </div>

        <a href="{{ route('packages') }}"
           class="text-pink-600 font-semibold hover:underline">
            Lihat Semua
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($packages as $package)
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <span class="text-sm text-pink-600 font-semibold">
                    {{ $package->kategori_layanan }}
                </span>

                <h3 class="text-lg font-bold mt-3 mb-2">
                    {{ $package->nama_paket }}
                </h3>

                <p class="text-gray-500 text-sm mb-5">
                    {{ $package->deskripsi }}
                </p>

                <p class="text-xl font-bold text-pink-600">
                    Rp{{ number_format($package->harga, 0, ',', '.') }}
                </p>
            </div>
        @empty
            <p>Belum ada paket tersedia.</p>
        @endforelse
    </div>
</section>

@endsection
