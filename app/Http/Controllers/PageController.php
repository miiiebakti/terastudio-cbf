<?php

namespace App\Http\Controllers;

use App\Services\ContentBasedRecommender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home(
        Request $request,
        ContentBasedRecommender $recommender
    ) {
        // Ambil pelanggan berdasarkan akun yang sedang login
        $customer = $request->user()?->customer;

        $recommendations = collect();
        $hasHistory = false;

        if ($customer) {
            // Periksa apakah pelanggan memiliki riwayat booking
            $hasHistory = $customer->bookings()->exists();

            // Jalankan CBF jika pelanggan punya riwayat booking
            if ($hasHistory) {
                $recommendations = $recommender->recommend(
                    $customer->id,
                    6
                );
            }
        }

        // Ambil paket untuk ditampilkan di Beranda
        $packages = DB::table('packages')
            ->orderBy('kategori_layanan')
            ->orderBy('harga')
            ->take(6)
            ->get();

        return view('home', compact(
            'customer',
            'recommendations',
            'hasHistory',
            'packages'
        ));
    }

    public function packages()
    {
        $packages = DB::table('packages')
            ->orderBy('kategori_layanan')
            ->orderBy('harga')
            ->get();

        return view('packages.index', compact('packages'));
    }
}