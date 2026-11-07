<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
    'kategori_layanan',
    'nama_paket',
    'deskripsi',
    'harga',
];

public function bookings()
{
    return $this->hasMany(Booking::class);
}
}
