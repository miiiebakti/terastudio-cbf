<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerAccountSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $customers = Customer::whereNull('user_id')->get();

            foreach ($customers as $customer) {

                // Email otomatis berdasarkan kode pelanggan
                $email = strtolower($customer->customer_code)
                    . '@terastudio.test';

                // Buat akun jika belum tersedia
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $customer->nama,
                        'password' => '12345678',
                    ]
                );

                // Hubungkan akun dengan data pelanggan
                if (!$user->customer()->exists()) {
                    $customer->update([
                        'user_id' => $user->id,
                    ]);
                }
            }
        });
    }
}
