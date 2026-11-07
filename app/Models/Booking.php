<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'booking_code',
    'customer_id',
    'package_id',
    'tanggal_pemesanan',
    'hari',
    'jam_pemesanan',
    'durasi',
    'layanan_tambahan',
    'total_pembayaran',
    'metode_pembayaran',
];

protected $casts = [
    'tanggal_pemesanan' => 'date',
];

public function customer()
{
    return $this->belongsTo(Customer::class);
}

public function package()
{
    return $this->belongsTo(Package::class);
}

public function rating()
{
    return $this->hasOne(Rating::class);
}
}
