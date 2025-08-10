import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => ({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        })
    ],

    build: {
        // Performance optimizations
        target: 'es2018',
        
        // Chunk splitting for better caching
        rollupOptions: {
            output: {
                manualChunks: {
                    // Vendor chunks
                    'alpine': ['alpinejs'],
                    'axios': ['axios']
                }
            }
        },

        // Build optimizations (using esbuild for better compatibility)
        minify: mode === 'production' ? 'esbuild' : false,
        
        // Source maps for debugging
        sourcemap: mode !== 'production',
        
        // Asset handling
        assetsInlineLimit: 4096, // 4kb - inline small assets
        
        // Build performance
        reportCompressedSize: true,
        chunkSizeWarningLimit: 500
    },

    // Development server optimizations
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            overlay: true
        }
    },

    // Dependency optimization
    optimizeDeps: {
        include: ['alpinejs', 'axios'],
        exclude: []
    },

    // Resolve configuration
    resolve: {
        alias: {
            '@': '/resources',
            '@js': '/resources/js',
            '@css': '/resources/css'
        }
    },

    // Define global constants
    define: {
        __APP_VERSION__: JSON.stringify(process.env.npm_package_version || '1.0.0'),
        __BUILD_TIME__: JSON.stringify(new Date().toISOString()),
        __DEV__: mode === 'development'
    }
}));
