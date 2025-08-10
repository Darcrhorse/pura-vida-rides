<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Image Preloading for LCP Optimization -->
    <link rel="preload" as="image" href="{{ asset('images/hero-index.jpg') }}"
          imagesrcset="{{ asset('images/hero-index.jpg') }} 1920w, {{ asset('images/results-strip.jpg') }} 1280w"
          imagesizes="(min-width:1024px) 100vw, 100vw">

    @if(app()->environment('production'))
        <link rel="stylesheet" href="{{ asset('build/assets/app-BWrdByhk.css') }}">
        <script type="module" src="{{ asset('build/assets/app-CkOcBP1u.js') }}"></script>
        <script type="module" src="{{ asset('build/assets/axios-wu1k_jD9.js') }}"></script>
        <script type="module" src="{{ asset('build/assets/alpine-8kmaoRXL.js') }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen flex flex-col bg-sand-50 font-body">
    <!-- Modern Navigation with Enhanced Sticky Header -->
    <header id="main-header" class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-sand-200 transition-all duration-300 ease-in-out">
        <div class="container mx-auto px-4 py-4 transition-all duration-300 ease-in-out">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center group">
                    <div class="text-3xl font-display font-bold">
                        <span class="text-gradient-pura-vida">Pura Vida</span>
                        <span class="text-caribbean-600 ml-2">Rides</span>
                    </div>
                    <span class="ml-2 text-2xl group-hover:animate-bounce">🌴</span>
                </a>
                
                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="font-medium text-sand-700 hover:text-caribbean-600 transition-colors duration-200 relative group">
                        <span class="flex items-center">
                            <span class="mr-1">🏠</span>
                            Inicio
                        </span>
                        <div class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-caribbean-500 to-forest-500 group-hover:w-full transition-all duration-300"></div>
                    </a>
                    <a href="{{ route('trips.index') }}" class="font-medium text-sand-700 hover:text-forest-600 transition-colors duration-200 relative group">
                        <span class="flex items-center">
                            <span class="mr-1">🔍</span>
                            Buscar Viajes
                        </span>
                        <div class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-forest-500 to-caribbean-500 group-hover:w-full transition-all duration-300"></div>
                    </a>
                    <a href="{{ route('trips.create') }}" class="font-medium text-sand-700 hover:text-golden-600 transition-colors duration-200 relative group">
                        <span class="flex items-center">
                            <span class="mr-1">🚗</span>
                            Ofrecer Viaje
                        </span>
                        <div class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-golden-500 to-volcano-500 group-hover:w-full transition-all duration-300"></div>
                    </a>
                </nav>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="{{ route('dashboard') }}" class="font-medium text-sand-700 hover:text-caribbean-600 transition-colors duration-200 flex items-center">
                                <span class="mr-1">👤</span>
                                Dashboard
                            </a>
                        </div>
                    @else
                        <div class="hidden sm:flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="font-medium text-sand-700 hover:text-caribbean-600 transition-colors duration-200 px-4 py-2 rounded-xl hover:bg-caribbean-50">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary text-sm">
                                <span class="mr-1">✨</span>
                                Registrarse
                            </a>
                        </div>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden p-2 text-sand-600 hover:text-caribbean-600 transition-colors duration-200" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="lg:hidden hidden mt-4 pb-4 border-t border-sand-200 pt-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-sand-700 hover:text-caribbean-600 hover:bg-caribbean-50 rounded-xl transition-colors duration-200">
                        <span class="mr-2">🏠</span>
                        Inicio
                    </a>
                    <a href="{{ route('trips.index') }}" class="flex items-center px-4 py-2 text-sand-700 hover:text-forest-600 hover:bg-forest-50 rounded-xl transition-colors duration-200">
                        <span class="mr-2">🔍</span>
                        Buscar Viajes
                    </a>
                    <a href="{{ route('trips.create') }}" class="flex items-center px-4 py-2 text-sand-700 hover:text-golden-600 hover:bg-golden-50 rounded-xl transition-colors duration-200">
                        <span class="mr-2">🚗</span>
                        Ofrecer Viaje
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sand-700 hover:text-caribbean-600 hover:bg-caribbean-50 rounded-xl transition-colors duration-200">
                            <span class="mr-2">👤</span>
                            Dashboard
                        </a>
                    @else
                        <div class="flex flex-col space-y-2 px-4 pt-2 border-t border-sand-200">
                            <a href="{{ route('login') }}" class="text-center py-2 text-sand-700 hover:text-caribbean-600 transition-colors duration-200">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary text-center justify-center">
                                <span class="mr-1">✨</span>
                                Registrarse
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Modern Footer -->
    <footer class="bg-gradient-to-br from-sand-800 to-sand-900 text-white py-16">
        <div class="container mx-auto px-4">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- Brand Column -->
                <div class="md:col-span-2">
                    <div class="flex items-center mb-4">
                        <div class="text-2xl font-display font-bold">
                            <span class="text-gradient-pura-vida">Pura Vida</span>
                            <span class="text-caribbean-400 ml-2">Rides</span>
                        </div>
                        <span class="ml-2 text-xl">🌴</span>
                    </div>
                    <p class="text-sand-300 mb-6 max-w-md leading-relaxed">
                        Conectamos a viajeros con conductores locales para crear experiencias auténticas y sostenibles por toda Costa Rica.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-caribbean-600 hover:bg-caribbean-500 rounded-full flex items-center justify-center transition-colors duration-200">
                            <span class="text-sm">📘</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-forest-600 hover:bg-forest-500 rounded-full flex items-center justify-center transition-colors duration-200">
                            <span class="text-sm">📸</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-volcano-600 hover:bg-volcano-500 rounded-full flex items-center justify-center transition-colors duration-200">
                            <span class="text-sm">🐦</span>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="font-display font-bold text-lg mb-4 text-white">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('trips.index') }}" class="text-sand-300 hover:text-caribbean-400 transition-colors duration-200 flex items-center">
                            <span class="mr-2">🔍</span>Buscar Viajes
                        </a></li>
                        <li><a href="{{ route('trips.create') }}" class="text-sand-300 hover:text-forest-400 transition-colors duration-200 flex items-center">
                            <span class="mr-2">🚗</span>Ofrecer Viaje
                        </a></li>
                        <li><a href="#" class="text-sand-300 hover:text-golden-400 transition-colors duration-200 flex items-center">
                            <span class="mr-2">ℹ️</span>Cómo Funciona
                        </a></li>
                        <li><a href="#" class="text-sand-300 hover:text-volcano-400 transition-colors duration-200 flex items-center">
                            <span class="mr-2">📞</span>Contacto
                        </a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h3 class="font-display font-bold text-lg mb-4 text-white">Soporte</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sand-300 hover:text-caribbean-400 transition-colors duration-200 flex items-center">
                            <span class="mr-2">🛡️</span>Seguridad
                        </a></li>
                        <li><a href="#" class="text-sand-300 hover:text-forest-400 transition-colors duration-200 flex items-center">
                            <span class="mr-2">📋</span>Términos
                        </a></li>
                        <li><a href="#" class="text-sand-300 hover:text-golden-400 transition-colors duration-200 flex items-center">
                            <span class="mr-2">🔒</span>Privacidad
                        </a></li>
                        <li><a href="#" class="text-sand-300 hover:text-volcano-400 transition-colors duration-200 flex items-center">
                            <span class="mr-2">❓</span>FAQ
                        </a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-sand-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-sand-400 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} Pura Vida Rides. Hecho con ❤️ en Costa Rica.
                </div>
                <div class="flex items-center text-sand-400 text-sm">
                    <span class="mr-2">🇨🇷</span>
                    Orgullosamente costarricense
                </div>
            </div>
        </div>
    </footer>

    <!-- Enhanced Mobile Menu Toggle & Sticky Header Script -->
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Enhanced sticky header with scroll behavior
        let lastScrollTop = 0;
        let scrollTimeout;
        const header = document.getElementById('main-header');
        
        function handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Clear existing timeout
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            
            // Debounce scroll events for performance
            scrollTimeout = setTimeout(() => {
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down - hide header
                    header.style.transform = 'translateY(-100%)';
                    header.classList.add('shadow-lg');
                } else {
                    // Scrolling up - show header
                    header.style.transform = 'translateY(0)';
                    if (scrollTop > 50) {
                        header.classList.add('shadow-lg', 'bg-white/98');
                        header.classList.remove('bg-white/95');
                    } else {
                        header.classList.remove('shadow-lg', 'bg-white/98');
                        header.classList.add('bg-white/95');
                    }
                }
                lastScrollTop = scrollTop;
            }, 10);
        }
        
        // Add scroll listener with passive flag for better performance
        window.addEventListener('scroll', handleScroll, { passive: true });
        
        // Intersection Observer for performance optimization
        const observerOptions = {
            rootMargin: '0px 0px -100px 0px',
            threshold: 0
        };
        
        const headerObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    header.classList.add('bg-white/98', 'shadow-lg');
                    header.classList.remove('bg-white/95');
                }
            });
        }, observerOptions);
        
        // Observe a sentinel element at the top of the page
        const sentinel = document.createElement('div');
        sentinel.style.height = '1px';
        sentinel.style.position = 'absolute';
        sentinel.style.top = '0';
        document.body.prepend(sentinel);
        headerObserver.observe(sentinel);
    </script>

    <!-- Enhanced Google Places Autocomplete -->
    <script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.key') }}&libraries=places&loading=async&callback=initAutocomplete"></script>
    <script>
    // Google Places Autocomplete with enhanced UX
    let autocompleteInstances = [];
    
    function initAutocomplete() {
        const autocompleteOptions = {
            componentRestrictions: { country: ['cr'] },
            fields: ['geometry', 'name', 'formatted_address', 'place_id'],
            types: ['(cities)']
        };
        
        // Find all autocomplete inputs
        const autocompleteInputs = document.querySelectorAll('input[name="from"], input[name="to"], .places-autocomplete');
        
        autocompleteInputs.forEach(input => {
            if (input && !input.dataset.autocompleteInitialized) {
                initializeAutocompleteForInput(input, autocompleteOptions);
                input.dataset.autocompleteInitialized = 'true';
            }
        });
    }
    
    function initializeAutocompleteForInput(input, options) {
        // Add loading indicator
        addLoadingIndicator(input);
        
        try {
            const autocomplete = new google.maps.places.Autocomplete(input, options);
            autocompleteInstances.push(autocomplete);
            
            // Add event listeners
            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                handlePlaceSelection(input, place);
            });
            
            // Add input event listeners for UX improvements
            input.addEventListener('input', function(e) {
                if (e.target.value.length > 2) {
                    showLoadingState(input);
                } else {
                    hideLoadingState(input);
                }
            });
            
            input.addEventListener('focus', function() {
                input.select();
            });
            
            // Remove loading indicator once initialized
            removeLoadingIndicator(input);
            
        } catch (error) {
            console.error('Error initializing autocomplete for input:', error);
            removeLoadingIndicator(input);
            showErrorState(input);
        }
    }
    
    function handlePlaceSelection(input, place) {
        hideLoadingState(input);
        
        if (!place.geometry) {
            showErrorMessage(input, 'No se encontraron detalles para esta ubicación.');
            return;
        }
        
        // Store place data
        input.dataset.placeId = place.place_id;
        input.dataset.lat = place.geometry.location.lat();
        input.dataset.lng = place.geometry.location.lng();
        
        // Show success state
        showSuccessState(input);
        
        // Auto-focus next field
        const nextInput = getNextInput(input);
        if (nextInput) {
            setTimeout(() => nextInput.focus(), 100);
        }
    }
    
    function addLoadingIndicator(input) {
        const wrapper = input.closest('.relative') || input.parentNode;
        if (!wrapper.querySelector('.autocomplete-loading')) {
            const loading = document.createElement('div');
            loading.className = 'autocomplete-loading absolute right-3 top-1/2 transform -translate-y-1/2';
            loading.innerHTML = '<div class="animate-spin h-4 w-4 border-2 border-caribbean-500 border-t-transparent rounded-full"></div>';
            wrapper.style.position = 'relative';
            wrapper.appendChild(loading);
        }
    }
    
    function removeLoadingIndicator(input) {
        const wrapper = input.closest('.relative') || input.parentNode;
        const loading = wrapper.querySelector('.autocomplete-loading');
        if (loading) loading.remove();
    }
    
    function showLoadingState(input) {
        input.classList.add('pr-10');
        const wrapper = input.closest('.relative') || input.parentNode;
        if (!wrapper.querySelector('.input-loading')) {
            const loading = document.createElement('div');
            loading.className = 'input-loading absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none';
            loading.innerHTML = '<div class="animate-pulse w-4 h-4 bg-caribbean-300 rounded-full"></div>';
            wrapper.style.position = 'relative';
            wrapper.appendChild(loading);
        }
    }
    
    function hideLoadingState(input) {
        const wrapper = input.closest('.relative') || input.parentNode;
        const loading = wrapper.querySelector('.input-loading');
        if (loading) loading.remove();
    }
    
    function showSuccessState(input) {
        input.classList.remove('border-red-500', 'border-gray-300');
        input.classList.add('border-green-500', 'bg-green-50');
        
        const wrapper = input.closest('.relative') || input.parentNode;
        const existing = wrapper.querySelector('.input-success');
        if (!existing) {
            const success = document.createElement('div');
            success.className = 'input-success absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none';
            success.innerHTML = '<svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
            wrapper.style.position = 'relative';
            wrapper.appendChild(success);
        }
    }
    
    function showErrorState(input) {
        input.classList.remove('border-green-500', 'border-gray-300');
        input.classList.add('border-red-500', 'bg-red-50');
        removeLoadingIndicator(input);
    }
    
    function showErrorMessage(input, message) {
        showErrorState(input);
        
        const wrapper = input.closest('.relative') || input.parentNode;
        let errorDiv = wrapper.querySelector('.autocomplete-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'autocomplete-error text-red-600 text-sm mt-1';
            wrapper.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
        
        setTimeout(() => {
            if (errorDiv) errorDiv.remove();
            input.classList.remove('border-red-500', 'bg-red-50');
            input.classList.add('border-gray-300');
        }, 3000);
    }
    
    function getNextInput(currentInput) {
        const inputs = document.querySelectorAll('input[name="from"], input[name="to"], input[name="date"]');
        const currentIndex = Array.from(inputs).indexOf(currentInput);
        return inputs[currentIndex + 1];
    }
    
    // Initialize autocomplete when Google Maps API is ready
    window.initAutocomplete = initAutocomplete;
    
    // Fallback initialization for cases where callback doesn't fire
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Google Maps API is already loaded
        if (typeof google !== 'undefined' && google.maps && google.maps.places) {
            initAutocomplete();
        } else {
            // Retry initialization every 500ms for up to 10 seconds
            let retries = 0;
            const maxRetries = 20;
            const retryInterval = setInterval(() => {
                if (typeof google !== 'undefined' && google.maps && google.maps.places) {
                    initAutocomplete();
                    clearInterval(retryInterval);
                } else if (retries >= maxRetries) {
                    console.error('Google Maps API failed to load after', maxRetries * 500, 'ms');
                    clearInterval(retryInterval);
                }
                retries++;
            }, 500);
        }
    });
    </script>
</body>
</html>
