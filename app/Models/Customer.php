<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'user_id',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}