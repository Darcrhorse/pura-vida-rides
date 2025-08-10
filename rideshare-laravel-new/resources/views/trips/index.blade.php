@extends('layouts.marketing')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-caribbean-50 to-forest-50 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center">
      <h1 class="text-4xl font-bold text-sand-900 mb-4">Viajes disponibles</h1>
      <p class="text-xl text-sand-700 max-w-2xl mx-auto">
        Descubre todos los viajes publicados por nuestra comunidad de conductores verificados
      </p>
    </div>
  </div>
</div>

<!-- Enhanced Quick Search Bar -->
<div class="bg-white border-b shadow-sm sticky top-20 z-40 transition-all duration-300">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <form id="search-form" method="GET" action="{{ route('search.index') }}" class="flex flex-col sm:flex-row gap-4 items-center">
      <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
        <div class="relative">
          <label for="from" class="sr-only">Ciudad de origen</label>
          <input id="from" name="from" type="text" placeholder="📍 Desde..." autocomplete="off"
                 class="places-autocomplete w-full border-sand-300 rounded-lg focus:ring-caribbean-500 focus:border-caribbean-500
                        px-4 py-3 text-base transition-all duration-200 hover:border-caribbean-400
                        focus:shadow-lg focus:scale-[1.02] transform"
                 value="{{ request('from') }}" />
          <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <div class="form-loading hidden">
              <div class="animate-spin h-4 w-4 border-2 border-caribbean-500 border-t-transparent rounded-full"></div>
            </div>
          </div>
        </div>
        
        <div class="relative">
          <label for="to" class="sr-only">Ciudad de destino</label>
          <input id="to" name="to" type="text" placeholder="🎯 Hacia..." autocomplete="off"
                 class="places-autocomplete w-full border-sand-300 rounded-lg focus:ring-caribbean-500 focus:border-caribbean-500
                        px-4 py-3 text-base transition-all duration-200 hover:border-caribbean-400
                        focus:shadow-lg focus:scale-[1.02] transform"
                 value="{{ request('to') }}" />
          <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <div class="form-loading hidden">
              <div class="animate-spin h-4 w-4 border-2 border-caribbean-500 border-t-transparent rounded-full"></div>
            </div>
          </div>
        </div>
        
        <div class="relative">
          <label for="date" class="sr-only">Fecha del viaje</label>
          <input id="date" name="date" type="date" min="{{ date('Y-m-d') }}"
                 class="w-full border-sand-300 rounded-lg focus:ring-caribbean-500 focus:border-caribbean-500
                        px-4 py-3 text-base transition-all duration-200 hover:border-caribbean-400
                        focus:shadow-lg focus:scale-[1.02] transform"
                 value="{{ request('date') }}" />
        </div>
      </div>
      
      <button type="submit" class="btn-primary whitespace-nowrap text-base px-6 py-3 min-w-[120px]
                                   transform hover:scale-[1.02] transition-all duration-200
                                   focus:ring-4 focus:ring-caribbean-500/50 disabled:opacity-50 disabled:cursor-not-allowed"
              id="search-btn">
        <span class="search-text">🔍 Buscar</span>
        <span class="search-loading hidden">
          <div class="inline-flex items-center">
            <div class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full mr-2"></div>
            Buscando...
          </div>
        </span>
      </button>
    </form>
    
    <!-- Search Progress Bar -->
    <div id="search-progress" class="hidden mt-4">
      <div class="w-full bg-sand-200 rounded-full h-1">
        <div class="bg-gradient-to-r from-caribbean-500 to-forest-500 h-1 rounded-full transition-all duration-300 ease-out"
             style="width: 0%" id="progress-bar"></div>
      </div>
    </div>
  </div>
</div>

<!-- Enhanced Search Form Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    const searchBtn = document.getElementById('search-btn');
    const searchProgress = document.getElementById('search-progress');
    const progressBar = document.getElementById('progress-bar');
    
    // Form submission handling with loading states
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const fromInput = document.getElementById('from');
        const toInput = document.getElementById('to');
        
        // Basic validation
        if (!fromInput.value.trim() || !toInput.value.trim()) {
            showFormError('Por favor completa los campos de origen y destino');
            return;
        }
        
        // Show loading state
        showSearchLoading();
        
        // Simulate search progress (replace with actual search logic)
        animateProgress();
        
        // Submit form after animation
        setTimeout(() => {
            searchForm.submit();
        }, 1500);
    });
    
    function showSearchLoading() {
        searchBtn.disabled = true;
        searchBtn.querySelector('.search-text').classList.add('hidden');
        searchBtn.querySelector('.search-loading').classList.remove('hidden');
        searchProgress.classList.remove('hidden');
    }
    
    function hideSearchLoading() {
        searchBtn.disabled = false;
        searchBtn.querySelector('.search-text').classList.remove('hidden');
        searchBtn.querySelector('.search-loading').classList.add('hidden');
        searchProgress.classList.add('hidden');
        progressBar.style.width = '0%';
    }
    
    function animateProgress() {
        let width = 0;
        const interval = setInterval(() => {
            width += Math.random() * 15 + 5;
            if (width >= 100) {
                width = 100;
                clearInterval(interval);
            }
            progressBar.style.width = width + '%';
        }, 100);
    }
    
    function showFormError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm';
        errorDiv.textContent = message;
        
        const existingError = document.querySelector('.form-error');
        if (existingError) existingError.remove();
        
        errorDiv.classList.add('form-error');
        searchForm.appendChild(errorDiv);
        
        setTimeout(() => errorDiv.remove(), 5000);
    }
    
    // Auto-clear validation states when user starts typing
    ['from', 'to'].forEach(id => {
        const input = document.getElementById(id);
        input.addEventListener('input', function() {
            this.classList.remove('border-red-500', 'bg-red-50');
            this.classList.add('border-sand-300');
            
            const error = document.querySelector('.form-error');
            if (error) error.remove();
        });
    });
});
</script>

<!-- Trips Listing -->
<div class="bg-sand-50 min-h-screen py-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Trips Count & Filters -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
      <div>
        <h2 class="text-2xl font-bold text-sand-900">
          {{ $trips->total() }} {{ Str::plural('viaje', $trips->total()) }} disponible{{ $trips->total() !== 1 ? 's' : '' }}
        </h2>
        <p class="text-sand-600 mt-1">Ordenados por fecha de salida</p>
      </div>
      
      <!-- Sort Options -->
      <div class="flex items-center space-x-2 mt-4 sm:mt-0">
        <span class="text-sm text-sand-600">Ordenar por:</span>
        <select class="text-sm border-sand-300 rounded-lg focus:ring-caribbean-500 focus:border-caribbean-500">
          <option>Fecha más cercana</option>
          <option>Precio menor</option>
          <option>Precio mayor</option>
        </select>
      </div>
    </div>

    <!-- Trip Cards Grid -->
    <div class="space-y-4">
      @forelse($trips as $trip)
      <!-- BlaBlaCar-Style Trip Card -->
      <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all duration-300 overflow-hidden">
        <div class="p-6">
          <!-- Header: Route & Price -->
          <div class="flex justify-between items-start mb-4">
            <div class="flex-1">
              <h3 class="text-xl font-bold text-sand-900 mb-2">
                {{ $trip->start_city }} → {{ $trip->end_city }}
              </h3>
              <div class="flex flex-wrap items-center gap-4 text-sm text-sand-600">
                <span class="flex items-center">
                  <span class="mr-2">📅</span>
                  {{ $trip->depart_at->format('l, j M • g:i A') }}
                </span>
                <span class="flex items-center">
                  <span class="mr-2">🚗</span>
                  {{ $trip->max_seats - $trip->bookings_count }} asientos disponibles
                </span>
                <span class="flex items-center">
                  <span class="mr-2">⏱️</span>
                  ~{{ rand(2, 5) }} horas
                </span>
              </div>
            </div>
            
            <!-- Price -->
            <div class="text-right ml-6">
              <div class="text-3xl font-bold text-caribbean-600">
                ₡{{ number_format($trip->price_per_seat) }}
              </div>
              <div class="text-sm text-sand-500">por persona</div>
            </div>
          </div>

          <!-- Driver & Vehicle Info -->
          <div class="flex items-center justify-between">
            <div class="flex items-center flex-1">
              <!-- Driver Avatar -->
              <div class="w-14 h-14 bg-gradient-to-br from-caribbean-400 to-caribbean-600 rounded-full flex items-center justify-center text-white text-lg font-bold mr-4">
                {{ substr($trip->driver->name ?? 'Driver', 0, 1) }}
              </div>
              
              <div class="flex-1">
                <div class="flex items-center mb-1">
                  <span class="font-semibold text-sand-900 mr-3">{{ $trip->driver->name ?? 'Conductor Verificado' }}</span>
                  <span class="px-2 py-1 bg-forest-100 text-forest-700 text-xs rounded-full font-medium">✅ Verificado</span>
                </div>
                <div class="flex items-center text-sm text-sand-600">
                  <span class="flex items-center mr-4">
                    <span class="text-golden-500 mr-1">⭐</span>
                    {{ $trip->driver->rating ?? '4.8' }} • {{ $trip->driver->trips_count ?? '42' }} viajes
                  </span>
                </div>
              </div>
            </div>

            <!-- Action Button -->
            <a href="{{ route('trips.show', $trip) }}"
               class="btn-primary inline-flex items-center px-8 py-3 ml-6">
              Ver detalles
              <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>

          <!-- Vehicle & Amenities -->
          <div class="mt-4 pt-4 border-t border-sand-100">
            <div class="flex flex-wrap items-center gap-6 text-sm text-sand-600">
              <span class="flex items-center">
                <span class="mr-2">🚙</span>
                {{ $trip->vehicle->make ?? 'Toyota' }} {{ $trip->vehicle->model ?? 'Corolla' }}
              </span>
              <span class="flex items-center">
                <span class="mr-2">❄️</span>
                Aire acondicionado
              </span>
              <span class="flex items-center">
                <span class="mr-2">🎵</span>
                Música permitida
              </span>
              <span class="flex items-center">
                <span class="mr-2">🚭</span>
                No fumar
              </span>
              <span class="flex items-center">
                <span class="mr-2">🧳</span>
                Equipaje mediano
              </span>
            </div>
          </div>
        </div>
      </div>
      @empty
      <!-- Empty State -->
      <div class="text-center py-20">
        <div class="text-8xl mb-8">🚗</div>
        <h3 class="text-3xl font-bold text-sand-900 mb-4">¡Aún no hay viajes disponibles!</h3>
        <p class="text-xl text-sand-600 mb-8 max-w-lg mx-auto leading-relaxed">
          Sé el primero en publicar un viaje y ayuda a otros viajeros a descubrir Costa Rica de manera sostenible y económica.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          @auth
            <a href="{{ route('trips.create') }}" class="btn-primary text-lg px-8 py-4">
              <span class="mr-2">✨</span>
              Publicar mi primer viaje
            </a>
          @else
            <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4">
              <span class="mr-2">🚀</span>
              Únete a la comunidad
            </a>
            <a href="{{ route('login') }}" class="btn-secondary text-lg px-8 py-4">
              Iniciar sesión
            </a>
          @endauth
        </div>
        
        <!-- Benefits for drivers -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
          <div class="text-center">
            <div class="w-16 h-16 bg-caribbean-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">💰</span>
            </div>
            <h4 class="font-bold text-sand-900 mb-2">Gana dinero extra</h4>
            <p class="text-sm text-sand-600">Comparte los gastos de combustible y peajes con otros pasajeros</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-forest-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">🌱</span>
            </div>
            <h4 class="font-bold text-sand-900 mb-2">Viaja sostenible</h4>
            <p class="text-sm text-sand-600">Reduce la huella de carbono compartiendo el viaje</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-golden-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">👥</span>
            </div>
            <h4 class="font-bold text-sand-900 mb-2">Conoce gente</h4>
            <p class="text-sm text-sand-600">Haz nuevos amigos y comparte experiencias increíbles</p>
          </div>
        </div>
      </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($trips->hasPages())
      <div class="mt-12">
        {{ $trips->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
