@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-5 py-10">

    {{-- Judul --}}
    <div class="mb-7">
        <h1 class="text-3xl font-bold text-[#0E2F76]">
            History Booking
        </h1>
        <p class="text-sm text-gray-600 mt-2">
            Lihat riwayat pesanan kamu di sini
        </p>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Tab Booking --}}
    <div class="flex gap-4 mb-8">
        <a href="{{ route('history.index', ['status' => 'upcoming']) }}"
           class="px-7 py-2 rounded-lg font-semibold text-sm
           {{ $status === 'upcoming' ? 'bg-[#0E2F76] text-white' : 'bg-[#AAC0E1] text-[#0E2F76]' }}">
            Mendatang
        </a>

        <a href="{{ route('history.index', ['status' => 'previous']) }}"
           class="px-7 py-2 rounded-lg font-semibold text-sm
           {{ $status === 'previous' ? 'bg-[#0E2F76] text-white' : 'bg-[#AAC0E1] text-[#0E2F76]' }}">
            Sebelumnya
        </a>
    </div>

    {{-- Daftar Booking --}}
    <div class="space-y-7">

        @forelse ($bookings as $booking)

            <div class="bg-white rounded-2xl shadow-lg p-4 md:p-5">

                <div class="flex flex-col md:flex-row gap-5">

                    {{-- Placeholder Foto --}}
                    <div class="w-full md:w-40 h-36 bg-gray-200 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-5xl">
                            {{ strtolower($booking->package->kategori_layanan) === 'photobox' ? '📸' : '🪞' }}
                        </span>
                    </div>

                    {{-- Informasi Booking --}}
                    <div class="flex-1">

                        <div class="flex flex-wrap justify-between gap-2">
                            <h2 class="font-bold text-lg text-[#0E2F76]">
                                {{ $booking->package->kategori_layanan }}
                            </h2>

                            @if ($booking->rating)
                                <span class="text-green-600 text-xs font-semibold">
                                    Sudah diberi rating
                                </span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-700 mt-1">
                            {{ $booking->package->nama_paket }}
                        </p>

                        <p class="text-sm text-gray-600 mt-3">
                            <span class="mr-2">📅</span>
                            {{ \Carbon\Carbon::parse($booking->tanggal_pemesanan)->translatedFormat('d F Y') }}
                            - {{ \Carbon\Carbon::parse($booking->jam_pemesanan)->format('H.i') }}
                        </p>

                        <p class="text-sm text-gray-600 mt-1">
                            <span class="mr-2">⏱️</span>
                            {{ $booking->durasi }} menit
                        </p>

                        <div class="border-t border-gray-200 mt-4 pt-4 flex flex-wrap items-center gap-4">

                            <p class="font-bold text-[#0E2F76] mr-2">
                                Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}
                            </p>

                            {{-- Detail Booking --}}
                            <details>
                                <summary class="cursor-pointer bg-[#0E2F76] text-white px-5 py-2 rounded-lg text-xs font-semibold">
                                    Lihat Detail Booking
                                </summary>

                                <div class="mt-3 p-4 bg-[#F5FEFF] rounded-xl text-sm space-y-2">
                                    <p><strong>Kode Booking:</strong> {{ $booking->booking_code }}</p>
                                    <p><strong>Paket:</strong> {{ $booking->package->nama_paket }}</p>
                                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->tanggal_pemesanan)->translatedFormat('d F Y') }}</p>
                                    <p><strong>Jam:</strong> {{ \Carbon\Carbon::parse($booking->jam_pemesanan)->format('H.i') }}</p>
                                    <p><strong>Durasi:</strong> {{ $booking->durasi }} menit</p>
                                    <p><strong>Layanan Tambahan:</strong> {{ $booking->layanan_tambahan ?: '-' }}</p>
                                    <p><strong>Metode Pembayaran:</strong> {{ $booking->metode_pembayaran }}</p>
                                </div>
                            </details>

                        </div>
                    </div>
                </div>

                {{-- Form Rating untuk Booking Sebelumnya --}}
                @if ($status === 'previous' && !$booking->rating)

                    <div class="border-t mt-5 pt-5">

                        <h3 class="font-bold text-lg text-[#0E2F76]">
                            Bagaimana pengalaman kamu menggunakan layanan kami?
                        </h3>

                        <p class="text-sm text-gray-600 mt-2">
                            Pilih rating dan tulis ulasan kamu di bawah ini.
                        </p>

                        <form action="{{ route('history.rating.store', $booking->id) }}"
                              method="POST"
                              class="mt-5">
                            @csrf


                        <div class="flex items-center gap-3 mb-5">
                            <div class="flex gap-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input
                                            type="radio"
                                            name="rating"
                                            value="{{ $i }}"
                                            required
                                            class="sr-only"
                                            onchange="updateRatingStars(this)"
                                        >

                                        <span
                                            data-rating-star="{{ $i }}"
                                            class="text-4xl text-gray-300 transition-colors duration-200"
                                        >★</span>
                                    </label>
                                @endfor
                            </div>

                            <span data-rating-value class="text-sm text-gray-500">
                                Belum dipilih
                            </span>
                        </div>


                            <label class="block text-sm font-semibold mb-2">
                                Tulis ulasan kamu
                            </label>

                            <textarea
                                name="ulasan"
                                rows="3"
                                maxlength="1000"
                                placeholder="Bagaimana pengalaman kamu mengenai paket ini..."
                                class="w-full border border-gray-300 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#AAC0E1]"
                            ></textarea>

                            <button type="submit"
                                class="w-full mt-3 bg-[#0E2F76] hover:bg-[#AAC0E1] hover:text-[#0E2F76] text-white font-semibold py-3 rounded-xl transition">
                                Kirim Rating
                            </button>
                        </form>

                    </div>

                @elseif ($status === 'previous' && $booking->rating)

                    <div class="border-t mt-5 pt-4">
                        <p class="font-semibold text-[#0E2F76]">
                            Rating kamu:
                            <span class="text-yellow-400">
                                {{ str_repeat('★', $booking->rating->rating) }}{{ str_repeat('☆', 5 - $booking->rating->rating) }}
                            </span>
                        </p>

                        @if ($booking->rating->ulasan)
                            <p class="text-sm text-gray-600 mt-2">
                                "{{ $booking->rating->ulasan }}"
                            </p>
                        @endif
                    </div>

                @endif

            </div>

        @empty

            <div class="bg-white rounded-2xl shadow p-10 text-center">
                <div class="text-5xl mb-4">📋</div>

                <h3 class="font-bold text-lg text-[#0E2F76]">
                    Belum ada booking
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    {{ $status === 'upcoming'
                        ? 'Kamu belum memiliki booking mendatang.'
                        : 'Belum ada riwayat booking sebelumnya.' }}
                </p>

                <a href="{{ route('home') }}"
            class="inline-block mt-5 bg-[#0E2F76] text-white px-6 py-3 rounded-lg text-sm">
                Kembali ke Beranda
            </a>
            </div>

        @endforelse

    </div>
</div>

<script>
    function updateRatingStars(input) {
        const form = input.closest('form');
        const selected = Number(input.value);

        const stars = form.querySelectorAll('[data-rating-star]');

        stars.forEach((star, index) => {
            if (index < selected) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });

        const ratingText = form.querySelector('[data-rating-value]');
        ratingText.textContent = selected + ' dari 5 bintang';
    }
</script>

@endsection
