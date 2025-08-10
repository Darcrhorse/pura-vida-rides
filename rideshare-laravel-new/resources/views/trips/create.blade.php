<x-app-layout>
  <div class="relative aspect-[2.33/1] overflow-hidden">
    <img src="{{ asset('images/offer-ride-hero.jpg') }}" alt="Offer a Ride" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/40 flex items-center">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-white">Offer a Ride</h1>
      </div>
    </div>
  </div>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Post a New Trip
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

          <form method="POST" action="{{ route('trips.store') }}" class="space-y-6">
            @csrf

            <div class="space-y-4">
              <h3 class="text-lg font-medium">Trip Details</h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <x-input-label for="start_city" :value="__('Departure City')" />
                  <x-text-input id="start_city" name="start_city" type="text" class="mt-1 block w-full" 
                    placeholder="e.g. San José" required />
                  <x-input-error :messages="$errors->get('start_city')" class="mt-2" />
                </div>

                <div>
                  <x-input-label for="end_city" :value="__('Destination City')" />
                  <x-text-input id="end_city" name="end_city" type="text" class="mt-1 block w-full" 
                    placeholder="e.g. Liberia" required />
                  <x-input-error :messages="$errors->get('end_city')" class="mt-2" />
                </div>
              </div>

              <div>
                <x-input-label for="depart_at" :value="__('Departure Date & Time')" />
                <x-text-input id="depart_at" name="depart_at" type="datetime-local" 
                  class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('depart_at')" class="mt-2" />
              </div>
            </div>

            <div class="space-y-4">
              <h3 class="text-lg font-medium">Vehicle Details</h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <x-input-label for="max_seats" :value="__('Available Seats')" />
                  <x-text-input id="max_seats" name="max_seats" type="number" min="1" max="8" 
                    class="mt-1 block w-full" required />
                  <x-input-error :messages="$errors->get('max_seats')" class="mt-2" />
                  <p class="mt-1 text-sm text-gray-500">How many passengers can you take?</p>
                </div>

                <div>
                  <x-input-label for="price_per_seat" :value="__('Price per Seat (₡)')" />
                  <x-text-input id="price_per_seat" name="price_per_seat" type="number" min="500" 
                    class="mt-1 block w-full" required />
                  <x-input-error :messages="$errors->get('price_per_seat')" class="mt-2" />
                  <p class="mt-1 text-sm text-gray-500">Cost per passenger in colones</p>
                </div>
              </div>
            </div>

            <div>
              <x-input-label for="notes" :value="__('Additional Notes')" />
              <x-textarea id="notes" name="notes" class="mt-1 block w-full" 
                placeholder="Any special instructions or details about your trip" />
              <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>

            <div class="flex justify-end">
              <x-primary-button type="submit">
                Post Trip
              </x-primary-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
