<?php

namespace App\Http\Controllers;

use App\Models\Trip;

class HomeController extends Controller
{
    public function index()
    {
        // Handle database gracefully for deployment scenarios
        try {
            $featuredTrips = Trip::with(['driver'])
                ->where('depart_at', '>', now())
                ->orderBy('depart_at')
                ->take(6)
                ->get();
        } catch (\Exception $e) {
            // If database is not configured or no trips exist, use empty collection
            $featuredTrips = collect([]);
        }

        return view('home', [
            'featuredTrips' => $featuredTrips
        ]);
    }
}
