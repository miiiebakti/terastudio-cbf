<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        $packages = DB::table('packages')
            ->orderBy('kategori_layanan')
            ->orderBy('harga')
            ->take(6)
            ->get();

        return view('home', compact('packages'));
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