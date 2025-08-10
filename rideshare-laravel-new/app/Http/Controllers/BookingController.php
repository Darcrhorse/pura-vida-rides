<?php
namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function __construct(){ $this->middleware(["auth","verified"]); }

    public function create(Trip $trip){
        $taken = $trip->bookings()->sum("seats_reserved");
        $left  = max($trip->max_seats - $taken, 0);
        return view("bookings.create", compact("trip","left"));
    }

    public function store(Request $r, Trip $trip){
        $data = $r->validate(["seats_reserved"=>"required|integer|min:1|max:8"]);
        return DB::transaction(function() use($trip,$data){
            $t = Trip::whereKey($trip->id)->lockForUpdate()->first();
            $taken = $t->bookings()->sum("seats_reserved");
            $left  = $t->max_seats - $taken;
            if($data["seats_reserved"] > $left){
                return back()->withErrors(["seats_reserved"=>"Only $left seats left"]);
            }
            Booking::create([
                "trip_id"=>$t->id,
                "rider_id"=>auth()->id(),
                "seats_reserved"=>$data["seats_reserved"],
                "status"=>"pending"
            ]);
            return redirect()->route("trips.show",$t)->with("ok","Seats reserved (pending)");
        });
    }
}
