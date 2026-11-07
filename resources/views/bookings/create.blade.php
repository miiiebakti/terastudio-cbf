
@extends('layouts.app')

@section('title', 'Booking Paket')

@section('content')

<section class="max-w-3xl mx-auto px-5 py-12">

    <div class="mb-8">
        <p class="text-sm font-bold tracking-widest text-[#AAC0E1]">
            TERASTUDIO
        </p>

        <h1 class="text-3xl font-extrabold text-[#0E2F76] mt-2">
            Booking Paket
        </h1>

        <p class="text-gray-500 text-sm mt-2">
            Lengkapi informasi booking untuk mengabadikan momenmu.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#AAC0E1]/40 p-6 md:p-8">

        <!-- Informasi Paket -->
        <div class="bg-[#F5FEFF] rounded-xl p-5 mb-7">
            <p class="text-xs text-gray-500 mb-1">
                Paket yang dipilih
            </p>

            <h2 class="text-xl font-bold text-[#0E2F76]">
                {{ $package->nama_paket }}
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                {{ $package->kategori_layanan }}
            </p>

            <div class="flex justify-between items-center mt-4">
                <span class="text-sm text-gray-500">
                    Durasi: {{ $package->durasi }} menit
                </span>

                <span class="text-lg font-extrabold text-[#0E2F76]">
                    Rp{{ number_format($package->harga, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <form action="{{ route('booking.store', $package->id) }}" method="POST">
            @csrf

            <!-- Tanggal -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2 text-[#0E2F76]">
                    Tanggal Booking
                </label>

                <input type="date"
                    name="tanggal_pemesanan"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('tanggal_pemesanan') }}"
                    required
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-[#AAC0E1]">

                @error('tanggal_pemesanan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2 text-[#0E2F76]">
                    Jam Booking
                </label>

                <input type="time"
                    name="jam_pemesanan"
                    min="09:00"
                    max="22:00"
                    value="{{ old('jam_pemesanan') }}"
                    required
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-[#AAC0E1]">

                @error('jam_pemesanan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <p class="text-xs text-gray-400 mt-1">
                    Jam operasional TeraStudio: 09.00–22.00.
                </p>
            </div>

            <!-- Layanan Tambahan -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2 text-[#0E2F76]">
                    Layanan Tambahan / Catatan
                </label>

                <textarea name="layanan_tambahan"
                    rows="3"
                    placeholder="Isi jika ada layanan tambahan atau catatan khusus..."
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-[#AAC0E1]">{{ old('layanan_tambahan') }}</textarea>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-7">
                <label class="block text-sm font-semibold mb-2 text-[#0E2F76]">
                    Metode Pembayaran
                </label>

                <select name="metode_pembayaran" required
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-white outline-none focus:ring-2 focus:ring-[#AAC0E1]">

                    <option value="">Pilih metode pembayaran</option>
                    <option value="Transfer" {{ old('metode_pembayaran') == 'Transfer' ? 'selected' : '' }}>
                        Transfer
                    </option>
                    <option value="Tunai" {{ old('metode_pembayaran') == 'Tunai' ? 'selected' : '' }}>
                        Tunai
                    </option>
                </select>

                @error('metode_pembayaran')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total -->
            <div class="border-t pt-5 mb-6 flex justify-between items-center">
                <span class="font-semibold text-gray-600">
                    Total Pembayaran
                </span>

                <span class="text-xl font-extrabold text-[#0E2F76]">
                    Rp{{ number_format($package->harga, 0, ',', '.') }}
                </span>
            </div>

            <button type="submit"
                class="w-full bg-[#0E2F76] text-white font-bold py-3 rounded-xl hover:bg-[#AAC0E1] transition">
                Konfirmasi Booking
            </button>

            <a href="{{ route('packages') }}"
                class="block text-center text-sm text-gray-500 mt-4 hover:text-[#0E2F76]">
                Kembali ke Katalog
            </a>

        </form>
    </div>
</section>

@endsection
