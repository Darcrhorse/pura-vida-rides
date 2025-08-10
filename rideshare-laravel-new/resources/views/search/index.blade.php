@extends('layouts.marketing')

@section('content')
<!-- Clean Header Section -->
<div class="bg-gradient-to-r from-caribbean-50 to-forest-50 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center">
      <h1 class="text-4xl font-bold text-sand-900 mb-4">Encuentra tu viaje ideal</h1>
      <p class="text-xl text-sand-700 max-w-2xl mx-auto">
        Busca entre cientos de viajes disponibles y viaja de forma cómoda y económica por Costa Rica
      </p>
    </div>
  </div>
</div>

<!-- Enhanced Search Form -->
<div class="bg-white border-b shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form method="GET" class="bg-white rounded-xl shadow-card p-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div>
          <label for="from" class="block text-sm font-medium text-sand-900 mb-2">
            📍 Desde
          </label>
          <x-text-input id="from" name="from" type="text"
            class="block w-full border-sand-300 rounded-lg focus:ring-caribbean-500 focus:border-caribbean-500"
            placeholder="San José, Alajuela..."
            value="{{ request('from') }}" />
        </div>

        <div>
          <label for="to" class="block text-sm font-medium text-sand-900 mb-2">
            🎯 Hacia
          </label>
          <x-text-input id="to" name="to" type="text"
            class="block w-full border-sand-300 rounded-lg focus:ring-caribbean-500 focus:border-caribbean-500"
            placeholder="Manuel Antonio, Tamarindo..."
            value="{{ request('to') }}" />
        </div>

        <div>
          <label for="date" class="block text-sm font-medium text-sand-900 mb-2">
            📅 Fecha
          </label>
          <x-text-input id="date" name="date" type="date"
            class="block w-full border-sand-300 rounded-lg focus:ring-caribbean-500 focus:border-caribbean-500"
            value="{{ request('date') }}" />
        </div>

        <div class="flex items-end">
          <button type="submit" class="w-full btn-primary py-3 font-semibold">
            🔍 Buscar Viajes
          </button>
        </div>
      </div>

      <!-- Quick Filters -->
      <div class="mt-6 pt-6 border-t border-sand-200">
        <div class="flex flex-wrap gap-3 items-center">
          <span class="text-sm text-sand-600 mr-2">Filtros rápidos:</span>
          <button type="button" class="px-4 py-2 text-sm bg-sand-100 hover:bg-sand-200 text-sand-700 rounded-full transition-colors duration-200">
            💰 Precio bajo
          </button>
          <button type="button" class="px-4 py-2 text-sm bg-sand-100 hover:bg-sand-200 text-sand-700 rounded-full transition-colors duration-200">
            ⚡ Salida pronto
          </button>
          <button type="button" class="px-4 py-2 text-sm bg-sand-100 hover:bg-sand-200 text-sand-700 rounded-full transition-colors duration-200">
            🚗 Con espacio
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Results Section -->
<div class="bg-sand-50 min-h-screen py-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if(request()->hasAny(['from', 'to', 'date']))
      <div class="mb-6">
        <h2 class="text-2xl font-bold text-sand-900 mb-2">Resultados de búsqueda</h2>
        <p class="text-sand-600">
          @if(request('from') && request('to'))
            Viajes de {{ request('from') }} a {{ request('to') }}
            @if(request('date'))
              • {{ \Carbon\Carbon::parse(request('date'))->format('d/m/Y') }}
            @endif
          @else
            Mostrando todos los viajes disponibles
          @endif
        </p>
      </div>
    @endif

    <!-- Trip Cards - BlaBlaCar Style -->
    <div class="space-y-4">
      @forelse($trips as $trip)
      <!-- Clean Trip Card -->
      <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all duration-300 overflow-hidden">
        <div class="p-6">
          <!-- Header: Route & Price -->
          <div class="flex justify-between items-start mb-4">
            <div>
              <h3 class="text-xl font-bold text-sand-900 mb-1">
                {{ $trip->start_city }} → {{ $trip->end_city }}
              </h3>
              <div class="flex items-center text-sm text-sand-600">
                <span class="mr-4">📅 {{ $trip->depart_at->format('l, j M • g:i A') }}</span>
                <span class="mr-4">🚗 {{ $trip->max_seats - $trip->bookings_count }} asientos disponibles</span>
              </div>
            </div>
            <div class="text-right">
              <div class="text-2xl font-bold text-caribbean-600">
                ₡{{ number_format($trip->price_per_seat) }}
              </div>
              <div class="text-sm text-sand-500">por persona</div>
            </div>
          </div>

          <!-- Driver & Vehicle Info -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <!-- Driver Avatar -->
              <div class="w-12 h-12 bg-gradient-to-br from-caribbean-400 to-caribbean-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                {{ substr($trip->driver->name ?? 'Driver', 0, 1) }}
              </div>
              
              <div>
                <div class="font-semibold text-sand-900">{{ $trip->driver->name ?? 'Conductor Verificado' }}</div>
                <div class="flex items-center text-sm text-sand-600">
                  <span class="flex items-center mr-4">
                    <span class="text-golden-500 mr-1">⭐</span>
                    {{ $trip->driver->rating ?? '4.8' }}
                  </span>
                  <span>{{ $trip->driver->trips_count ?? '42' }} viajes</span>
                </div>
              </div>
            </div>

            <!-- Action Button -->
            <a href="{{ route('trips.show', $trip) }}"
               class="btn-primary inline-flex items-center px-8 py-3">
              Ver detalles
              <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>

          <!-- Vehicle & Comfort Info -->
          <div class="mt-4 pt-4 border-t border-sand-100">
            <div class="flex items-center text-sm text-sand-600 space-x-6">
              <span class="flex items-center">
                <span class="mr-1">🚙</span>
                {{ $trip->vehicle->make ?? 'Toyota' }} {{ $trip->vehicle->model ?? 'Corolla' }}
              </span>
              <span class="flex items-center">
                <span class="mr-1">❄️</span>
                Aire acondicionado
              </span>
              <span class="flex items-center">
                <span class="mr-1">🎵</span>
                Música permitida
              </span>
              <span class="flex items-center">
                <span class="mr-1">🚭</span>
                No fumar
              </span>
            </div>
          </div>
        </div>
      </div>
      @empty
      <!-- Empty State -->
      <div class="text-center py-16">
        <div class="text-6xl mb-6">🔍</div>
        <h3 class="text-2xl font-bold text-sand-900 mb-4">No encontramos viajes</h3>
        <p class="text-lg text-sand-600 mb-8 max-w-md mx-auto">
          @if(request()->hasAny(['from', 'to', 'date']))
            No hay viajes disponibles que coincidan con tu búsqueda. Intenta con otras fechas o destinos.
          @else
            Aún no hay viajes publicados. ¡Sé el primero en ofrecer uno!
          @endif
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          @if(request()->hasAny(['from', 'to', 'date']))
            <a href="{{ route('search.index') }}" class="btn-secondary">
              🔄 Nueva búsqueda
            </a>
          @endif
          <a href="{{ route('trips.create') }}" class="btn-primary">
            <span class="mr-2">✨</span>
            Ofrecer un viaje
          </a>
        </div>
      </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($trips, 'links'))
      <div class="mt-8">
        {{ $trips->appends(request()->query())->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
