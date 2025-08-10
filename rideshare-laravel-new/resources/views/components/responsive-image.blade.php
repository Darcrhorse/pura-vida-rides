@props([
    'src' => '',
    'alt' => '',
    'class' => '',
    'sizes' => '(min-width: 1024px) 100vw, (min-width: 768px) 50vw, 100vw',
    'lazy' => true,
    'priority' => false,
    'aspectRatio' => null,
    'webp' => true
])

@php
    // Generate different image sizes for responsive loading
    $imagePath = $src;
    $imageBase = pathinfo($imagePath, PATHINFO_FILENAME);
    $imageExt = pathinfo($imagePath, PATHINFO_EXTENSION);
    
    // Define responsive breakpoints
    $breakpoints = [
        'sm' => 640,
        'md' => 768, 
        'lg' => 1024,
        'xl' => 1280,
        'full' => 1920
    ];
    
    // Generate srcset for different sizes
    $srcset = collect($breakpoints)->map(function($width, $size) use ($imageBase, $imageExt) {
        return "{{ asset('images/optimized/{$imageBase}_{$size}.{$imageExt}') }} {$width}w";
    })->implode(', ');
    
    // WebP support
    $webpSrcset = $webp ? collect($breakpoints)->map(function($width, $size) use ($imageBase) {
        return "{{ asset('images/webp/{$imageBase}_{$size}.webp') }} {$width}w";
    })->implode(', ') : '';
    
    $loadingClass = $lazy ? 'lazy-image' : '';
    $loadingAttr = $lazy && !$priority ? 'lazy' : 'eager';
@endphp

<div class="responsive-image-container {{ $class }}" 
     @if($aspectRatio) style="aspect-ratio: {{ $aspectRatio }};" @endif>
    
    @if($webp)
    <picture class="w-full h-full">
        <!-- WebP format for supported browsers -->
        <source 
            type="image/webp"
            @if($lazy && !$priority)
                data-srcset="{{ $webpSrcset }}"
            @else
                srcset="{{ $webpSrcset }}"
            @endif
            sizes="{{ $sizes }}"
        >
        <!-- Fallback to original format -->
        <source 
            @if($lazy && !$priority)
                data-srcset="{{ $srcset }}"
            @else
                srcset="{{ $srcset }}"
            @endif
            sizes="{{ $sizes }}"
        >
        <img 
            @if($lazy && !$priority)
                data-src="{{ asset($imagePath) }}"
                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E"
            @else
                src="{{ asset($imagePath) }}"
            @endif
            alt="{{ $alt }}"
            class="w-full h-full object-cover {{ $loadingClass }} transition-opacity duration-300"
            loading="{{ $loadingAttr }}"
            @if($priority) fetchpriority="high" @endif
            onload="this.classList.add('loaded')"
            onerror="this.src='{{ asset('images/placeholder-fallback.jpg') }}'"
        >
    </picture>
    @else
    <img 
        @if($lazy && !$priority)
            data-src="{{ asset($imagePath) }}"
            data-srcset="{{ $srcset }}"
            src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E"
        @else
            src="{{ asset($imagePath) }}"
            srcset="{{ $srcset }}"
        @endif
        alt="{{ $alt }}"
        class="w-full h-full object-cover {{ $loadingClass }} transition-opacity duration-300"
        sizes="{{ $sizes }}"
        loading="{{ $loadingAttr }}"
        @if($priority) fetchpriority="high" @endif
        onload="this.classList.add('loaded')"
        onerror="this.src='{{ asset('images/placeholder-fallback.jpg') }}'"
    >
    @endif
    
    <!-- Loading placeholder -->
    <div class="image-placeholder absolute inset-0 bg-gradient-to-br from-sand-100 to-sand-200 flex items-center justify-center">
        <div class="animate-pulse">
            <div class="w-16 h-16 bg-sand-300 rounded-lg flex items-center justify-center">
                <svg class="w-8 h-8 text-sand-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Error fallback -->
    <div class="image-error hidden absolute inset-0 bg-sand-50 border-2 border-dashed border-sand-300 flex items-center justify-center">
        <div class="text-center text-sand-500">
            <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <p class="text-sm">Image not available</p>
        </div>
    </div>
</div>

<style>
.responsive-image-container {
    @apply relative overflow-hidden bg-sand-100;
}

.lazy-image {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.lazy-image.loaded {
    opacity: 1;
}

.lazy-image.loaded + .image-placeholder {
    display: none;
}

.image-error-show .image-error {
    display: flex !important;
}

.image-error-show .image-placeholder,
.image-error-show img {
    display: none !important;
}
</style>