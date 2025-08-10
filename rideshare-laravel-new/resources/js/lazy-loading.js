/**
 * Lazy Loading Implementation with Intersection Observer
 * Optimized for performance and modern browsers
 */

class LazyImageLoader {
    constructor(options = {}) {
        this.options = {
            rootMargin: '50px 0px',
            threshold: 0.1,
            enableWebP: true,
            fadeInDuration: 300,
            retryDelay: 2000,
            maxRetries: 3,
            ...options
        };
        
        this.observer = null;
        this.loadedImages = new Set();
        this.failedImages = new Map();
        this.init();
    }

    init() {
        // Check for Intersection Observer support
        if (!('IntersectionObserver' in window)) {
            this.fallbackLoad();
            return;
        }

        // Create intersection observer
        this.observer = new IntersectionObserver(
            (entries) => this.handleIntersection(entries),
            this.options
        );

        // Start observing lazy images
        this.observeImages();
        
        // Handle dynamically added images
        this.setupMutationObserver();
    }

    observeImages() {
        const lazyImages = document.querySelectorAll('.lazy-image:not(.loaded)');
        lazyImages.forEach(img => {
            if (!this.loadedImages.has(img)) {
                this.observer.observe(img);
            }
        });
    }

    handleIntersection(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                this.loadImage(img);
                this.observer.unobserve(img);
            }
        });
    }

    async loadImage(img) {
        try {
            // Show loading state
            this.showLoadingState(img);
            
            // Check if we should use WebP
            const useWebP = this.options.enableWebP && this.supportsWebP();
            
            // Load the image
            const src = await this.getImageSrc(img, useWebP);
            await this.preloadImage(src);
            
            // Update image source
            img.src = src;
            
            // Update srcset if available
            const srcset = img.dataset.srcset;
            if (srcset) {
                img.srcset = srcset;
            }
            
            // Mark as loaded
            this.markAsLoaded(img);
            
        } catch (error) {
            console.warn('Failed to load image:', error);
            this.handleImageError(img, error);
        }
    }

    async getImageSrc(img, useWebP = false) {
        let src = img.dataset.src || img.src;
        
        if (useWebP && src) {
            // Try to get WebP version
            const webpSrc = this.convertToWebP(src);
            if (await this.imageExists(webpSrc)) {
                return webpSrc;
            }
        }
        
        return src;
    }

    convertToWebP(src) {
        // Convert image path to WebP equivalent
        const pathParts = src.split('.');
        pathParts.pop(); // Remove original extension
        return pathParts.join('.') + '.webp';
    }

    async imageExists(src) {
        return new Promise(resolve => {
            const img = new Image();
            img.onload = () => resolve(true);
            img.onerror = () => resolve(false);
            img.src = src;
        });
    }

    preloadImage(src) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            
            img.onload = () => {
                resolve(img);
            };
            
            img.onerror = () => {
                reject(new Error(`Failed to load image: ${src}`));
            };
            
            // Set loading timeout
            setTimeout(() => {
                reject(new Error('Image loading timeout'));
            }, 10000);
            
            img.src = src;
        });
    }

    showLoadingState(img) {
        const container = img.closest('.responsive-image-container');
        if (container) {
            const placeholder = container.querySelector('.image-placeholder');
            if (placeholder) {
                placeholder.style.display = 'flex';
            }
        }
    }

    markAsLoaded(img) {
        img.classList.add('loaded');
        this.loadedImages.add(img);
        
        // Hide placeholder
        const container = img.closest('.responsive-image-container');
        if (container) {
            const placeholder = container.querySelector('.image-placeholder');
            if (placeholder) {
                setTimeout(() => {
                    placeholder.style.display = 'none';
                }, this.options.fadeInDuration);
            }
        }
        
        // Dispatch loaded event
        img.dispatchEvent(new CustomEvent('lazyImageLoaded', {
            detail: { src: img.src }
        }));
    }

    handleImageError(img, error) {
        const retryCount = this.failedImages.get(img) || 0;
        
        if (retryCount < this.options.maxRetries) {
            // Retry loading
            this.failedImages.set(img, retryCount + 1);
            setTimeout(() => {
                this.loadImage(img);
            }, this.options.retryDelay * (retryCount + 1));
        } else {
            // Show error state
            this.showErrorState(img);
        }
    }

    showErrorState(img) {
        const container = img.closest('.responsive-image-container');
        if (container) {
            container.classList.add('image-error-show');
            
            // Try fallback image
            const fallbackSrc = img.dataset.fallback || '/images/placeholder-fallback.jpg';
            if (fallbackSrc && img.src !== fallbackSrc) {
                img.src = fallbackSrc;
                img.classList.add('loaded');
            }
        }
        
        // Dispatch error event
        img.dispatchEvent(new CustomEvent('lazyImageError', {
            detail: { error: 'Failed to load after retries' }
        }));
    }

    supportsWebP() {
        // Check WebP support
        if (!this._webpSupport) {
            const canvas = document.createElement('canvas');
            canvas.width = 1;
            canvas.height = 1;
            this._webpSupport = canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
        }
        return this._webpSupport;
    }

    setupMutationObserver() {
        // Watch for new lazy images added to DOM
        const mutationObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) { // Element node
                        const lazyImages = node.querySelectorAll ? 
                            node.querySelectorAll('.lazy-image:not(.loaded)') : [];
                        
                        lazyImages.forEach(img => {
                            if (!this.loadedImages.has(img)) {
                                this.observer.observe(img);
                            }
                        });
                        
                        // Check if the node itself is a lazy image
                        if (node.classList?.contains('lazy-image') && !node.classList.contains('loaded')) {
                            if (!this.loadedImages.has(node)) {
                                this.observer.observe(node);
                            }
                        }
                    }
                });
            });
        });

        mutationObserver.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    fallbackLoad() {
        // Fallback for browsers without Intersection Observer
        const lazyImages = document.querySelectorAll('.lazy-image:not(.loaded)');
        
        lazyImages.forEach(async (img) => {
            try {
                await this.loadImage(img);
            } catch (error) {
                this.handleImageError(img, error);
            }
        });
    }

    refresh() {
        // Re-observe new lazy images
        this.observeImages();
    }

    destroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize lazy loading
    window.lazyImageLoader = new LazyImageLoader({
        rootMargin: '100px 0px',
        threshold: 0.1,
        enableWebP: true,
        fadeInDuration: 300
    });
    
    // Refresh on page transitions (for SPAs)
    window.addEventListener('popstate', () => {
        setTimeout(() => window.lazyImageLoader.refresh(), 100);
    });
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LazyImageLoader;
}