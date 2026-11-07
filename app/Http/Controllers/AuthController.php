<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    
public function register(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'nomor_hp' => 'required|string|max:20',
        'usia' => 'required|integer|min:1',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'kota_asal' => 'required|string|max:100',
        'pekerjaan' => 'required|string|max:100',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = DB::transaction(function () use ($validated) {

        // Cari nomor customer_code terbesar yang sudah digunakan
        $lastNumber = Customer::query()
            ->selectRaw(
                'MAX(CAST(SUBSTRING(customer_code, 6) AS UNSIGNED)) as max_code'
            )
            ->value('max_code');

        $customerCode = 'CUST-' . str_pad(
            ($lastNumber ?? 0) + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

        // Buat akun pengguna
        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        // Buat data pelanggan
        Customer::create([
            'customer_code' => $customerCode,
            'nama' => $validated['nama'],
            'nomor_hp' => $validated['nomor_hp'],
            'usia' => $validated['usia'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'kota_asal' => $validated['kota_asal'],
            'pekerjaan' => $validated['pekerjaan'],
            'user_id' => $user->id,
        ]);

        return $user;
    });

    Auth::login($user);

    $request->session()->regenerate();

    return redirect()->route('home')
        ->with('success', 'Registrasi berhasil! Selamat datang.');
}


    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
