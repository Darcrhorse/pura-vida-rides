<x-app-layout>
  <!-- Booking Banner -->
  <div class="relative aspect-video overflow-hidden">
    <img src="{{ asset('images/booking-banner.jpg') }}" alt="Secure Booking" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/40 flex items-center">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-white">Secure Your Seat</h1>
        <p class="text-lg text-white mt-2">Complete your booking with confidence</p>
      </div>
    </div>
  </div>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Reserve Seats
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-700 rounded">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('ok'))
            <div class="mb-4 p-4 bg-green-50 text-green-700 rounded">
              {{ session('ok') }}
            </div>
          @endif

          <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-medium">Trip Details</h3>
            <p class="mt-2">{{ $trip->start_city }} → {{ $trip->end_city }}</p>
            <p class="mt-2"><span class="font-medium">Seats available:</span> {{ $left }}</p>
          </div>

          <form method="POST" action="{{ route('bookings.store',$trip) }}" class="space-y-6">
            @csrf

            <div>
              <x-input-label for="seats_reserved" :value="__('Seats to Reserve')" />
              <x-text-input id="seats_reserved" name="seats_reserved" type="number" 
                min="1" max="{{ $left }}" value="1" class="mt-1 block w-full"
                {{ $left==0 ? 'disabled' : '' }} />
              <x-input-error :messages="$errors->get('seats_reserved')" class="mt-2" />
              <p class="mt-1 text-sm text-gray-500">Number of seats you want to reserve (max {{ $left }})</p>
            </div>

            <div class="flex justify-end">
              <x-primary-button type="submit" {{ $left==0 ? 'disabled' : '' }}>
                Confirm Reservation
              </x-primary-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
