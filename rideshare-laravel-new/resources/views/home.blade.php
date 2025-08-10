<x-app-layout>
    <!-- Immersive Hero Section -->
    <section class="relative min-h-screen flex items-center overflow-hidden">
      <!-- Background with parallax effect -->
      <div class="absolute inset-0">
        <picture>
          <source srcset="{{ asset('images/hero-index.jpg') }} 1920w, {{ asset('images/results-strip.jpg') }} 1280w"
                  sizes="100vw" type="image/jpeg">
          <img src="{{ asset('images/hero-index.jpg') }}"
               alt="Discover Costa Rica's Paradise Through Shared Journeys"
               class="w-full h-full object-cover animate-float"
               width="1920" height="1080"
               loading="eager" decoding="async" fetchpriority="high">
        </picture>
        <div class="absolute inset-0 gradient-paradise"></div>
      </div>
      
      <!-- Hero Content -->
      <div class="relative z-10 container mx-auto px-4 text-center text-white">
        <div class="animate-slide-up">
          <h1 class="font-display font-bold mb-6">
            <span class="block text-display-xl">
              <span class="text-gradient-pura-vida">Pura Vida</span>
            </span>
            <span class="block text-display-lg">Rides Costa Rica</span>
          </h1>
          <p class="text-xl lg:text-2xl mb-12 max-w-3xl mx-auto opacity-90 leading-relaxed">
            🌴 Connect with locals and travelers<br>
            🚗 Share amazing journeys across paradise<br>
            ❤️ Experience the true spirit of Costa Rica
          </p>
        </div>
        
        <!-- Modern Search Widget -->
        <div class="card-glass p-8 max-w-5xl mx-auto animate-slide-up">
          <form action="{{ route('search.index') }}" method="GET" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
              <div class="lg:col-span-1">
                <label for="from" class="block text-sm font-medium text-white/90 mb-2">
                  📍 Desde
                </label>
                <x-text-input id="from" name="from" type="text"
                  class="block w-full bg-white/10 border-white/20 text-white placeholder-white/60 focus:border-golden-400 focus:ring-golden-400"
                  placeholder="San José, Alajuela..." />
              </div>
              <div class="lg:col-span-1">
                <label for="to" class="block text-sm font-medium text-white/90 mb-2">
                  🏖️ Hacia
                </label>
                <x-text-input id="to" name="to" type="text"
                  class="block w-full bg-white/10 border-white/20 text-white placeholder-white/60 focus:border-golden-400 focus:ring-golden-400"
                  placeholder="Manuel Antonio, Tamarindo..." />
              </div>
              <div class="lg:col-span-1">
                <label for="date" class="block text-sm font-medium text-white/90 mb-2">
                  📅 Fecha
                </label>
                <x-text-input id="date" name="date" type="date"
                  class="block w-full bg-white/10 border-white/20 text-white focus:border-golden-400 focus:ring-golden-400" />
              </div>
              <div class="lg:col-span-1 flex items-end">
                <button type="submit" class="w-full btn-accent text-lg font-bold py-4">
                  🔍 Buscar Viajes
                </button>
              </div>
            </div>
            
            <!-- Quick destination buttons -->
            <div class="flex flex-wrap gap-2 justify-center pt-4">
              <span class="text-white/70 text-sm mr-4">Destinos populares:</span>
              @foreach(['Manuel Antonio', 'Tamarindo', 'Monteverde', 'Jacó'] as $destination)
                <button type="button" onclick="document.getElementById('to').value='{{ $destination }}'"
                  class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-full text-sm transition-all duration-200 hover:scale-105">
                  {{ $destination }}
                </button>
              @endforeach
            </div>
          </form>
        </div>
      </div>
      
      <!-- Scroll Indicator -->
      <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-8 h-8 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
      </div>
    </section>

    <!-- How Pura Vida Rides Works -->
    <section class="py-20 bg-gradient-to-br from-sand-50 to-sand-100">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-display-lg font-display font-bold mb-6">
            ¿Cómo funciona <span class="text-gradient-pura-vida">Pura Vida Rides</span>?
          </h2>
          <p class="text-xl text-sand-700 max-w-3xl mx-auto">
            Conectamos a viajeros con conductores locales para crear experiencias auténticas y sostenibles por toda Costa Rica
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
          <!-- Step 1: Search -->
          <div class="group text-center">
            <div class="relative mb-6">
              <div class="w-20 h-20 bg-gradient-to-br from-caribbean-500 to-caribbean-600 rounded-2xl flex items-center justify-center mx-auto shadow-card group-hover:shadow-card-hover transition-all duration-300 group-hover:scale-110">
                <span class="text-3xl">🔍</span>
              </div>
              <div class="absolute -top-2 -right-2 w-8 h-8 bg-golden-500 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
            </div>
            <h3 class="text-2xl font-display font-bold mb-4 text-sand-900">Busca tu viaje ideal</h3>
            <p class="text-sand-700 leading-relaxed">
              Encuentra viajes que vayan hacia tu destino. Filtra por fecha, precio y tipo de vehículo para encontrar la opción perfecta.
            </p>
          </div>
          
          <!-- Step 2: Book -->
          <div class="group text-center">
            <div class="relative mb-6">
              <div class="w-20 h-20 bg-gradient-to-br from-forest-500 to-forest-600 rounded-2xl flex items-center justify-center mx-auto shadow-card group-hover:shadow-card-hover transition-all duration-300 group-hover:scale-110">
                <span class="text-3xl">🎯</span>
              </div>
              <div class="absolute -top-2 -right-2 w-8 h-8 bg-golden-500 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
            </div>
            <h3 class="text-2xl font-display font-bold mb-4 text-sand-900">Reserva con confianza</h3>
            <p class="text-sand-700 leading-relaxed">
              Conecta con conductores verificados, revisa sus calificaciones y reserva tu asiento de forma segura en pocos clics.
            </p>
          </div>
          
          <!-- Step 3: Enjoy -->
          <div class="group text-center">
            <div class="relative mb-6">
              <div class="w-20 h-20 bg-gradient-to-br from-volcano-500 to-golden-500 rounded-2xl flex items-center justify-center mx-auto shadow-card group-hover:shadow-card-hover transition-all duration-300 group-hover:scale-110">
                <span class="text-3xl">🌴</span>
              </div>
              <div class="absolute -top-2 -right-2 w-8 h-8 bg-golden-500 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
            </div>
            <h3 class="text-2xl font-display font-bold mb-4 text-sand-900">¡Disfruta el viaje!</h3>
            <p class="text-sand-700 leading-relaxed">
              Conoce gente increíble, comparte historias, ahorra dinero y descubre Costa Rica de una manera auténtica y sostenible.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Popular Routes -->
    <section class="py-20 bg-sand-50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-display-lg font-display font-bold mb-6 text-sand-900">Rutas Populares</h2>
          <p class="text-xl text-sand-700 max-w-2xl mx-auto">
            Descubre los destinos más solicitados por viajeros y locales
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          @forelse($featuredTrips as $trip)
          <!-- Modern Trip Card -->
          <div class="group card overflow-hidden">
            <!-- Card Image -->
            <div class="relative aspect-[4/3] overflow-hidden">
              <img src="{{ asset('images/result-card-default.jpg') }}"
                   alt="{{ $trip->start_city }} to {{ $trip->end_city }}"
                   class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
              
              <!-- Route Badge -->
              <div class="absolute top-4 left-4 bg-caribbean-500 text-white px-3 py-1.5 rounded-full text-sm font-medium">
                {{ $trip->start_city }} → {{ $trip->end_city }}
              </div>
              
              <!-- Price Badge -->
              <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm text-sand-900 px-3 py-1.5 rounded-full text-sm font-bold">
                ₡{{ number_format((int)$trip->price_per_seat) }}
              </div>
              
              <!-- Available Seats -->
              <div class="absolute bottom-4 left-4 bg-forest-500 text-white px-3 py-1.5 rounded-full text-sm font-medium flex items-center">
                <span class="mr-1">🚗</span>
                {{ $trip->max_seats - $trip->bookings_count }} asientos
              </div>
            </div>
            
            <!-- Card Content -->
            <div class="p-6">
              <!-- Driver Info -->
              <div class="flex items-center mb-4">
                <img src="{{ $trip->driver->profile_photo_url ?? asset('images/driver-default.jpg') }}"
                     alt="{{ $trip->driver->name }}"
                     class="w-12 h-12 rounded-full border-2 border-caribbean-200">
                <div class="ml-3 flex-1">
                  <h3 class="font-display font-semibold text-sand-900">{{ $trip->driver->name }}</h3>
                  <div class="flex items-center text-sm text-sand-600">
                    <div class="flex items-center text-golden-500 mr-3">
                      <span class="mr-1">⭐</span>
                      <span class="font-medium">{{ $trip->driver->rating ?? '4.9' }}</span>
                    </div>
                    <span>{{ $trip->driver->trips_count ?? '127' }} viajes</span>
                  </div>
                </div>
              </div>
              
              <!-- Trip Details -->
              <div class="space-y-2 mb-6">
                <div class="flex items-center text-sm text-sand-600">
                  <span class="mr-2">📅</span>
                  {{ optional($trip->depart_at)->timezone(config('app.timezone'))->format('l, j M • g:i A') ?? 'Mañana, 15 Feb • 2:30 PM' }}
                </div>
                <div class="flex items-center text-sm text-sand-600">
                  <span class="mr-2">🚙</span>
                  {{ $trip->vehicle->make ?? 'Toyota' }} {{ $trip->vehicle->model ?? 'RAV4' }} • Aire acondicionado
                </div>
              </div>
              
              <!-- CTA Button -->
              <button class="w-full btn-primary">
                Ver Detalles del Viaje
              </button>
            </div>
          </div>
          @empty
          <!-- Empty State -->
          <div class="col-span-full text-center py-12">
            <div class="text-6xl mb-4">🚗</div>
            <h3 class="text-xl font-display font-semibold mb-2 text-sand-900">¡Próximamente más viajes!</h3>
            <p class="text-sand-600 mb-6">Sé el primero en ofrecer un viaje y conecta con otros viajeros</p>
            <a href="{{ route('trips.create') }}" class="btn-secondary inline-flex items-center">
              <span class="mr-2">✨</span>
              Ofrecer un viaje
            </a>
          </div>
          @endforelse
        </div>
        
        @if(isset($featuredTrips) && $featuredTrips->count() > 0)
        <div class="text-center mt-12">
          <a href="{{ route('trips.index') }}" class="btn-primary inline-flex items-center text-lg">
            <span class="mr-2">🔍</span>
            Ver Todos los Viajes Disponibles
          </a>
        </div>
        @endif
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-gradient-to-br from-caribbean-50 to-forest-50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-display-lg font-display font-bold mb-6 text-sand-900">
            Lo que dicen nuestros <span class="text-gradient-pura-vida">viajeros</span>
          </h2>
          <p class="text-xl text-sand-700 max-w-2xl mx-auto">
            Historias reales de costarricenses y turistas que han vivido la experiencia Pura Vida
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Testimonial 1: Local -->
          <div class="card p-8 text-center">
            <img src="{{ asset('images/testimonial-maria.jpg') }}"
                 alt="María González"
                 class="w-20 h-20 rounded-full mx-auto mb-6 border-4 border-caribbean-200">
            <div class="flex justify-center text-golden-500 text-xl mb-4">
              ⭐⭐⭐⭐⭐
            </div>
            <p class="text-sand-700 mb-6 text-lg leading-relaxed italic">
              "Como conductora, he conocido gente increíble de todo el mundo. Es bonito mostrar mi país y ganar un dinero extra."
            </p>
            <div class="font-display font-semibold text-sand-900">María González</div>
            <div class="text-caribbean-600 text-sm">Conductora desde San José</div>
          </div>
          
          <!-- Testimonial 2: Tourist -->
          <div class="card p-8 text-center">
            <img src="{{ asset('images/testimonial-john.jpg') }}"
                 alt="John Miller"
                 class="w-20 h-20 rounded-full mx-auto mb-6 border-4 border-forest-200">
            <div class="flex justify-center text-golden-500 text-xl mb-4">
              ⭐⭐⭐⭐⭐
            </div>
            <p class="text-sand-700 mb-6 text-lg leading-relaxed italic">
              "Amazing way to travel Costa Rica! I saved money and made local friends who showed me hidden gems."
            </p>
            <div class="font-display font-semibold text-sand-900">John Miller</div>
            <div class="text-forest-600 text-sm">Tourist from Canada</div>
          </div>
          
          <!-- Testimonial 3: Local -->
          <div class="card p-8 text-center">
            <img src="{{ asset('images/testimonial-carlos.jpg') }}"
                 alt="Carlos Ramírez"
                 class="w-20 h-20 rounded-full mx-auto mb-6 border-4 border-volcano-200">
            <div class="flex justify-center text-golden-500 text-xl mb-4">
              ⭐⭐⭐⭐⭐
            </div>
            <p class="text-sand-700 mb-6 text-lg leading-relaxed italic">
              "Perfecto para ir a la playa los fines de semana. Siempre encuentro ride y la pasamos tuanis."
            </p>
            <div class="font-display font-semibold text-sand-900">Carlos Ramírez</div>
            <div class="text-volcano-600 text-sm">Viajero frecuente a Guanacaste</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Trust & Safety -->
    <section class="py-20 bg-sand-100">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-display-lg font-display font-bold mb-6 text-sand-900">
            Tu seguridad es nuestra <span class="text-gradient-pura-vida">prioridad</span>
          </h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 bg-forest-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">✅</span>
            </div>
            <h3 class="font-display font-semibold mb-2 text-sand-900">Conductores Verificados</h3>
            <p class="text-sm text-sand-600">Cédula y licencia validadas</p>
          </div>
          
          <div class="text-center">
            <div class="w-16 h-16 bg-caribbean-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">⭐</span>
            </div>
            <h3 class="font-display font-semibold mb-2 text-sand-900">Sistema de Reseñas</h3>
            <p class="text-sm text-sand-600">Calificaciones reales</p>
          </div>
          
          <div class="text-center">
            <div class="w-16 h-16 bg-golden-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">🛡️</span>
            </div>
            <h3 class="font-display font-semibold mb-2 text-sand-900">Seguro Incluido</h3>
            <p class="text-sm text-sand-600">Cobertura durante el viaje</p>
          </div>
          
          <div class="text-center">
            <div class="w-16 h-16 bg-volcano-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">📞</span>
            </div>
            <h3 class="font-display font-semibold mb-2 text-sand-900">Soporte 24/7</h3>
            <p class="text-sm text-sand-600">Ayuda cuando la necesites</p>
          </div>
        </div>
      </div>
    </section>
</x-app-layout>
