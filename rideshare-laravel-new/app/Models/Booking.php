<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model { 
    protected $fillable=["trip_id","rider_id","seats_reserved","status","charge_id"]; 
    public function trip(){return $this->belongsTo(\App\Models\Trip::class);} 
    public function rider(){return $this->belongsTo(\App\Models\User::class,"rider_id"); }
    //
}
