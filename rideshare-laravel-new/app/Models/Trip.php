<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model 
{
    use HasFactory;

    protected $fillable = [
        "driver_id",
        "start_city",
        "start_lat", 
        "start_lng",
        "end_city",
        "end_lat",
        "end_lng",
        "depart_at",
        "max_seats",
        "price_per_seat",
        "status",
        "notes"
    ];

    protected $casts = [
        "depart_at" => "datetime"
    ];

    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class);
    }

    public function driver()
    {
        return $this->belongsTo(\App\Models\User::class, "driver_id");
    }
}
