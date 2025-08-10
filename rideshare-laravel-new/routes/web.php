<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{HomeController,TripController,BookingController,SearchController,VehicleController};

Route::get('/', [HomeController::class, "index"])->name("home");
Route::get('/search',[SearchController::class,'index'])->name('search.index');

Route::get("/trips",[TripController::class,"index"])->name("trips.index");

Route::middleware(["auth","verified"])->group(function(){
    Route::get("/trips/create",[TripController::class,"create"])->name("trips.create");
    Route::post("/trips",[TripController::class,"store"])->name("trips.store");
    Route::get("/trips/{trip}",[TripController::class,"show"])->name("trips.show");
    Route::get("/trips/{trip}/book",[BookingController::class,"create"])->name("bookings.create");
    Route::post("/trips/{trip}/book",[BookingController::class,"store"])->name("bookings.store");
    
    Route::resource('vehicles', VehicleController::class)->except(['show']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Legacy route redirects
Route::redirect('/login.html', '/login');
Route::redirect('/register.html', '/register');
Route::redirect('/register.php', '/register');
Route::redirect('/offer-ride.html', '/trips/create');
Route::redirect('/details.html', '/search');
Route::redirect('/booking.html', '/search');
