<?php

namespace App\Http\Controllers;

use App\Models\Trip;

class HomeController extends Controller
{
    public function index()
    {
        $featuredTrips = Trip::with(['driver'])
            ->where('depart_at', '>', now())
            ->orderBy('depart_at')
            ->take(6)
            ->get();

        return view('home', [
            'featuredTrips' => $featuredTrips
        ]);
    }
}
