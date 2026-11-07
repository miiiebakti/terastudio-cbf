<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
    'customer_code',
    'nama',
    'nomor_hp',
    'usia',
    'jenis_kelamin',
    'kota_asal',
    'pekerjaan',
];

public function bookings()
{
    return $this->hasMany(Booking::class);
}

public function ratings()
{
    return $this->hasMany(Rating::class);
}
}
