
@extends('layouts.app')

@section('title', 'Katalog Paket')

@section('content')

<section class="max-w-7xl mx-auto px-6 py-14">

    <div class="mb-10">
        <p class="text-pink-600 font-semibold">TERASTUDIO</p>
        <h1 class="text-3xl font-bold mt-2">Katalog Paket</h1>
        <p class="text-gray-500 mt-2">
            Pilih paket foto yang sesuai dengan kebutuhanmu.
        </p>
    </div>

    @php
        $groupedPackages = $packages->groupBy('kategori_layanan');
    @endphp

    @foreach ($groupedPackages as $category => $items)
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6">
                {{ $category }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($items as $package)
                    <div class="bg-white rounded-xl shadow-sm border p-6">
                        <h3 class="text-lg font-bold mb-3">
                            {{ $package->nama_paket }}
                        </h3>

                        <p class="text-gray-500 text-sm mb-5">
                            {{ $package->deskripsi }}
                        </p>

                        <div class="flex justify-between items-center">
                            <span class="text-pink-600 font-bold text-lg">
                                Rp{{ number_format($package->harga, 0, ',', '.') }}
                            </span>

                            <span class="text-sm text-gray-500">
                                {{ $package->durasi ?? '' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</section>

@endsection
