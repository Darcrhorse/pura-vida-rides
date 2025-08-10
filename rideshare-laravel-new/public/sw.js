/**
 * Service Worker for Pura Vida Rides
 * Implements caching strategies for optimal performance
 */

const CACHE_NAME = 'pura-vida-rides-v1.0.0';
const STATIC_CACHE = 'static-assets-v1';
const DYNAMIC_CACHE = 'dynamic-content-v1';

// Assets to cache immediately
const STATIC_ASSETS = [
    '/',
    '/build/assets/app.css',
    '/build/assets/app.js',
    '/images/placeholder-fallback.jpg',
    'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap'
];

// Runtime caching rules
const CACHE_STRATEGIES = {
    images: {
        cacheName: 'images-cache-v1',
        maxAge: 7 * 24 * 60 * 60 * 1000, // 7 days
        maxEntries: 100
    },
    api: {
        cacheName: 'api-cache-v1',
        maxAge: 5 * 60 * 1000, // 5 minutes
        maxEntries: 50
    },
    pages: {
        cacheName: 'pages-cache-v1',
        maxAge: 24 * 60 * 60 * 1000, // 1 day
        maxEntries: 30
    }
};

// Install event
self.addEventListener('install', (event) => {
    console.log('Service Worker: Installing...');
    
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => {
                console.log('Service Worker: Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            })
            .then(() => {
                return self.skipWaiting();
            })
            .catch((error) => {
                console.error('Service Worker: Installation failed', error);
            })
    );
});

// Activate event
self.addEventListener('activate', (event) => {
    console.log('Service Worker: Activating...');
    
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        // Delete old caches
                        if (cacheName !== CACHE_NAME && cacheName !== STATIC_CACHE && cacheName !== DYNAMIC_CACHE) {
                            console.log('Service Worker: Deleting old cache', cacheName);
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
            .then(() => {
                return self.clients.claim();
            })
    );
});

// Fetch event
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);
    
    // Skip non-GET requests
    if (request.method !== 'GET') {
        return;
    }
    
    // Handle different types of requests
    if (url.pathname.startsWith('/images/')) {
        event.respondWith(handleImageRequest(request));
    } else if (url.pathname.startsWith('/api/')) {
        event.respondWith(handleApiRequest(request));
    } else if (request.destination === 'document') {
        event.respondWith(handlePageRequest(request));
    } else {
        event.respondWith(handleStaticRequest(request));
    }
});

// Image request handler - Cache First strategy
async function handleImageRequest(request) {
    try {
        const cache = await caches.open(CACHE_STRATEGIES.images.cacheName);
        const cachedResponse = await cache.match(request);
        
        if (cachedResponse) {
            // Check if cache is expired
            const cacheDate = cachedResponse.headers.get('cache-date');
            if (cacheDate && (Date.now() - parseInt(cacheDate)) < CACHE_STRATEGIES.images.maxAge) {
                return cachedResponse;
            }
        }
        
        // Fetch from network
        const networkResponse = await fetch(request);
        
        if (networkResponse.ok) {
            // Clone response and add cache date
            const responseClone = networkResponse.clone();
            const responseWithDate = new Response(await responseClone.arrayBuffer(), {
                status: responseClone.status,
                statusText: responseClone.statusText,
                headers: {
                    ...Object.fromEntries(responseClone.headers.entries()),
                    'cache-date': Date.now().toString()
                }
            });
            
            // Cache the response
            await cache.put(request, responseWithDate.clone());
            
            // Clean up old entries
            await cleanupCache(cache, CACHE_STRATEGIES.images.maxEntries);
            
            return responseWithDate;
        }
        
        // Return cached version if network fails
        return cachedResponse || createFallbackResponse(request);
        
    } catch (error) {
        console.error('Image request failed:', error);
        return createFallbackResponse(request);
    }
}

// API request handler - Network First strategy
async function handleApiRequest(request) {
    const cache = await caches.open(CACHE_STRATEGIES.api.cacheName);
    
    try {
        // Try network first
        const networkResponse = await Promise.race([
            fetch(request),
            new Promise((_, reject) => 
                setTimeout(() => reject(new Error('Network timeout')), 3000)
            )
        ]);
        
        if (networkResponse.ok) {
            // Cache successful response
            const responseWithDate = new Response(await networkResponse.clone().text(), {
                status: networkResponse.status,
                statusText: networkResponse.statusText,
                headers: {
                    ...Object.fromEntries(networkResponse.headers.entries()),
                    'cache-date': Date.now().toString()
                }
            });
            
            await cache.put(request, responseWithDate.clone());
            return responseWithDate;
        }
        
        throw new Error('Network response not ok');
        
    } catch (error) {
        console.log('Network failed, trying cache:', error.message);
        
        // Fallback to cache
        const cachedResponse = await cache.match(request);
        if (cachedResponse) {
            const cacheDate = cachedResponse.headers.get('cache-date');
            if (!cacheDate || (Date.now() - parseInt(cacheDate)) < CACHE_STRATEGIES.api.maxAge) {
                return cachedResponse;
            }
        }
        
        // Return error response if no cache available
        return new Response(JSON.stringify({ error: 'Service unavailable' }), {
            status: 503,
            headers: { 'Content-Type': 'application/json' }
        });
    }
}

// Page request handler - Stale While Revalidate strategy
async function handlePageRequest(request) {
    const cache = await caches.open(CACHE_STRATEGIES.pages.cacheName);
    
    try {
        // Get from cache immediately if available
        const cachedResponse = await cache.match(request);
        
        // Fetch from network in background
        const networkPromise = fetch(request).then(async (response) => {
            if (response.ok) {
                await cache.put(request, response.clone());
            }
            return response;
        });
        
        // Return cached version immediately, or wait for network
        return cachedResponse || await networkPromise;
        
    } catch (error) {
        console.error('Page request failed:', error);
        
        // Return offline page or basic HTML
        return new Response(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Offline - Pura Vida Rides</title>
                <meta name="viewport" content="width=device-width, initial-scale=1">
            </head>
            <body>
                <div style="text-align: center; padding: 50px; font-family: Arial, sans-serif;">
                    <h1>🌴 Pura Vida Rides</h1>
                    <h2>You're currently offline</h2>
                    <p>Please check your internet connection and try again.</p>
                    <button onclick="window.location.reload()">Retry</button>
                </div>
            </body>
            </html>
        `, {
            status: 200,
            headers: { 'Content-Type': 'text/html' }
        });
    }
}

// Static asset handler - Cache First strategy
async function handleStaticRequest(request) {
    const cache = await caches.open(STATIC_CACHE);
    const cachedResponse = await cache.match(request);
    
    if (cachedResponse) {
        return cachedResponse;
    }
    
    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            await cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        console.error('Static request failed:', error);
        return cachedResponse;
    }
}

// Utility functions
async function cleanupCache(cache, maxEntries) {
    const keys = await cache.keys();
    if (keys.length > maxEntries) {
        const keysToDelete = keys.slice(0, keys.length - maxEntries);
        await Promise.all(keysToDelete.map(key => cache.delete(key)));
    }
}

function createFallbackResponse(request) {
    const url = new URL(request.url);
    
    if (url.pathname.includes('image') || request.destination === 'image') {
        // Return fallback image
        return fetch('/images/placeholder-fallback.jpg').catch(() => {
            return new Response('', { status: 404 });
        });
    }
    
    return new Response('Resource not available offline', { status: 404 });
}

// Background sync for failed requests
self.addEventListener('sync', (event) => {
    console.log('Service Worker: Background sync triggered');
    
    if (event.tag === 'background-sync') {
        event.waitUntil(handleBackgroundSync());
    }
});

async function handleBackgroundSync() {
    // Handle any failed requests that were queued
    console.log('Handling background sync...');
}

// Push notifications
self.addEventListener('push', (event) => {
    if (event.data) {
        const data = event.data.json();
        const options = {
            body: data.body,
            icon: '/images/icon-192x192.png',
            badge: '/images/badge-72x72.png',
            tag: data.tag || 'general',
            renotify: true,
            requireInteraction: data.requireInteraction || false
        };
        
        event.waitUntil(
            self.registration.showNotification(data.title, options)
        );
    }
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    
    event.waitUntil(
        clients.openWindow(event.notification.data?.url || '/')
    );
});