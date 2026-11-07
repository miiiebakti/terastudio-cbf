<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CsvImportSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/data kita.csv');

        if (!File::exists($path)) {
            throw new \Exception('File data kita.csv tidak ditemukan!');
        }

        $file = fopen($path, 'r');

        $headers = fgetcsv($file);

        // Membersihkan BOM pada header CSV
        $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', $headers[0]);

        DB::transaction(function () use ($file, $headers) {

            while (($row = fgetcsv($file)) !== false) {

                if (count($headers) !== count($row)) {
                    continue;
                }

                $data = array_combine($headers, $row);

                // 1. Import Customer
                $customer = DB::table('customers')
                    ->updateOrInsert(
                        ['customer_code' => $data['ID Pelanggan']],
                        [
                            'nama' => $data['Nama Pelanggan'],
                            'nomor_hp' => (string) $data['Nomor HP'],
                            'usia' => $data['Usia'],
                            'jenis_kelamin' => $data['Jenis Kelamin'],
                            'kota_asal' => $data['Kota Asal'],
                            'pekerjaan' => $data['Pekerjaan'],
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );

                $customerId = DB::table('customers')
                    ->where('customer_code', $data['ID Pelanggan'])
                    ->value('id');

                // 2. Import Package
                $package = DB::table('packages')
                    ->where('kategori_layanan', $data['Kategori Layanan'])
                    ->where('nama_paket', $data['Paket'])
                    ->first();

                if (!$package) {
                    $packageId = DB::table('packages')->insertGetId([
                        'kategori_layanan' => $data['Kategori Layanan'],
                        'nama_paket' => $data['Paket'],
                        'deskripsi' => $data['Deskripsi Paket'],
                        'harga' => $data['Harga Paket'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $packageId = $package->id;
                }

                // 3. Import Booking
                DB::table('bookings')->updateOrInsert(
                    ['booking_code' => $data['ID Pemesanan']],
                    [
                        'customer_id' => $customerId,
                        'package_id' => $packageId,
                        'tanggal_pemesanan' => $data['Tanggal Pemesanan'],
                        'hari' => $data['Hari'],
                        'jam_pemesanan' => $data['Jam Pemesanan'],
                        'durasi' => $data['Durasi (Menit)'],
                        'layanan_tambahan' => $data['Layanan Tambahan'],
                        'total_pembayaran' => $data['Total Pembayaran'],
                        'metode_pembayaran' => $data['Metode Pembayaran'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                $bookingId = DB::table('bookings')
                    ->where('booking_code', $data['ID Pemesanan'])
                    ->value('id');

                // 4. Import Rating
                DB::table('ratings')->updateOrInsert(
                    ['booking_id' => $bookingId],
                    [
                        'customer_id' => $customerId,
                        'rating' => $data['Penilaian'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        });

        fclose($file);

        $this->command->info('Import dataset TeraStudio berhasil!');
    }
}
