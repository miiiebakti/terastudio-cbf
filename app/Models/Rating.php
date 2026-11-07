<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
protected $fillable = [
    'booking_id',
    'customer_id',
    'rating',
    'ulasan',
];

public function booking()
{
    return $this->belongsTo(Booking::class);
}

public function customer()
{
    return $this->belongsTo(Customer::class);
}
}
