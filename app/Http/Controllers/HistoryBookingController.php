<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryBookingController extends Controller
{
    public function index(Request $request)
    {
        $customer = Auth::user()->customer;

        if (!$customer) {
            abort(403, 'Akun pelanggan belum terhubung.');
        }

        $status = $request->query('status', 'upcoming');

        $query = Booking::with(['package', 'rating'])
            ->where('customer_id', $customer->id);

        if ($status === 'previous') {
            $query->whereDate('tanggal_pemesanan', '<', today())
                ->orderBy('tanggal_pemesanan', 'desc');
        } else {
            $status = 'upcoming';

            $query->whereDate('tanggal_pemesanan', '>=', today())
                ->orderBy('tanggal_pemesanan', 'asc');
        }

        $bookings = $query->get();

        return view('bookings.history', compact(
            'bookings',
            'status'
        ));
    }

    public function storeRating(Request $request, Booking $booking)
    {
        $customer = Auth::user()->customer;

        if (!$customer || $booking->customer_id !== $customer->id) {
            abort(403, 'Booking tidak ditemukan.');
        }

        // if ($booking->tanggal_pemesanan->isFuture() ||
        //     $booking->tanggal_pemesanan->isToday()) {
        //     return back()->with('error', 'Booking belum selesai.');
        // }

        if ($booking->rating()->exists()) {
            return back()->with('error', 'Booking ini sudah diberi rating.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ]);

        Rating::create([
            'booking_id' => $booking->id,
            'customer_id' => $customer->id,
            'rating' => $validated['rating'],
            'ulasan' => $validated['ulasan'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih! Rating dan ulasan berhasil dikirim.');
    }
}
