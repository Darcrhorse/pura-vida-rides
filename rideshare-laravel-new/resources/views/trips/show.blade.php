@extends('layouts.marketing')

@section('content')
<div class="relative aspect-[2.33/1] overflow-hidden">
    <img src="{{ asset('images/trip-hero-default.jpg') }}" alt="Trip Details" class="w-full h-full object-cover">
  <div class="absolute inset-0 bg-black/40 flex items-center">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-4xl font-bold text-white">Trip Details</h1>
    </div>
  </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-6">Trip Details</h1>

    @if (session("ok"))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session("ok") }}
    </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-2">{{ $trip->start_city }} → {{ $trip->end_city }}</h2>
        <div class="space-y-2">
            <p><span class="font-medium">Departs:</span> {{ $trip->depart_at->format("Y-m-d H:i") }}</p>
            <p><span class="font-medium">Price per seat:</span> ₡{{ number_format($trip->price_per_seat) }}</p>
            <p><span class="font-medium">Seats left:</span> {{ $left }}</p>
        </div>
    </div>

    @auth
    <form method="POST" action="{{ route('bookings.store',$trip) }}" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Seats to reserve</label>
                <input name="seats_reserved" type="number" min="1" max="{{ $left }}" value="1" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal focus:border-teal"
                       {{ $left==0 ? 'disabled' : '' }}>
            </div>
            <div class="md:col-span-2">
                <button type="submit" 
                        class="w-full bg-teal text-white py-2 px-4 rounded-md hover:bg-teal-600 transition-colors"
                        {{ $left==0 ? 'disabled' : '' }}>
                    Reserve Seats
                </button>
            </div>
        </div>
    </form>
    @endauth
</div>
@endsection
