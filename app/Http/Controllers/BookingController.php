<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Package $package)
    {
        return view('bookings.create', compact('package'));
    }

    public function store(Request $request, Package $package)
    {
        $validated = $request->validate([
            'tanggal_pemesanan' => 'required|date|after_or_equal:today',
            'jam_pemesanan' => 'required|date_format:H:i',
            'layanan_tambahan' => 'nullable|string|max:255',
            'metode_pembayaran' => 'required|string|max:50',
        ]);

        $customer = Auth::user()->customer;

        if (!$customer) {
            return redirect()->route('home')
                ->with('error', 'Akun pelanggan belum terhubung.');
        }

        $tanggal = Carbon::parse($validated['tanggal_pemesanan'])
            ->locale('id');

        $booking = Booking::create([
            'booking_code' => 'TS-' . strtoupper(Str::random(10)),
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'tanggal_pemesanan' => $validated['tanggal_pemesanan'],
            'hari' => $tanggal->translatedFormat('l'),
            'jam_pemesanan' => $validated['jam_pemesanan'],
            'durasi' => $package->durasi,
            'layanan_tambahan' => $validated['layanan_tambahan'] ?? null,
            'total_pembayaran' => $package->harga,
            'metode_pembayaran' => $validated['metode_pembayaran'],
        ]);

        return redirect()->route('home')
            ->with('success', 'Booking berhasil dibuat! Kode booking: ' . $booking->booking_code);
    }
}
