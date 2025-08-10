<?php
namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TripController extends Controller
{
    public function __construct(){ 
        $this->middleware(["auth","verified"])->except(['index']); 
    }

    public function index()
    {
        $trips = Trip::where('depart_at', '>', now())
            ->orderBy('depart_at')
            ->paginate(10);
            
        return view('trips.index', compact('trips'));
    }

    public function create(){ return view("trips.create"); }

    public function store(Request $r){
        $data = $r->validate([
            "start_city"=>"required|string|max:80",
            "start_lat"=>"required|numeric",
            "start_lng"=>"required|numeric",
            "end_city"=>"required|string|max:80",
            "end_lat"=>"required|numeric",
            "end_lng"=>"required|numeric",
            "depart_at"=>"required|date|after:now",
            "max_seats"=>"required|integer|min:1|max:8",
            "price_per_seat"=>"required|integer|min:500|max:50000",
            "notes"=>"nullable|string|max:500",
        ]);
        $trip = Trip::create($data + ["driver_id"=>auth()->id(),"status"=>"open"]);
        return redirect()->route("trips.show",$trip)->with("ok","Trip posted!");
    }

    public function show(Trip $trip){
        $trip->load("bookings");
        $taken = $trip->bookings()->sum("seats_reserved");
        $left  = max($trip->max_seats - $taken, 0);
        return view("trips.show", compact("trip","left"));
    }
}
