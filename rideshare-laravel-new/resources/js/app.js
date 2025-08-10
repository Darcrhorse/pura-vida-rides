import './bootstrap';
import './lazy-loading';

import Alpine from 'alpinejs';

// Performance monitoring
window.performanceMetrics = {
    start: performance.now(),
    marks: {},
    measures: {}
};

// Mark performance milestones
function markPerformance(name) {
    window.performanceMetrics.marks[name] = performance.now();
    if (typeof gtag !== 'undefined') {
        gtag('event', 'performance_mark', {
            'custom_parameter': name,
            'value': Math.round(performance.now() - window.performanceMetrics.start)
        });
    }
}

// Alpine.js optimization
window.Alpine = Alpine;

// Start Alpine with performance monitoring
markPerformance('alpine_start');
Alpine.start();

// Mark when Alpine is fully loaded
document.addEventListener('alpine:init', () => {
    markPerformance('alpine_ready');
});

// Performance monitoring for Core Web Vitals
function reportWebVitals() {
    // Largest Contentful Paint (LCP)
    new PerformanceObserver((list) => {
        const entries = list.getEntries();
        const lastEntry = entries[entries.length - 1];
        console.log('LCP:', lastEntry.startTime);
        markPerformance('lcp');
    }).observe({ entryTypes: ['largest-contentful-paint'] });

    // First Input Delay (FID)
    new PerformanceObserver((list) => {
        const entries = list.getEntries();
        entries.forEach((entry) => {
            console.log('FID:', entry.processingStart - entry.startTime);
            markPerformance('fid');
        });
    }).observe({ entryTypes: ['first-input'] });

    // Cumulative Layout Shift (CLS)
    let clsValue = 0;
    new PerformanceObserver((list) => {
        const entries = list.getEntries();
        entries.forEach((entry) => {
            if (!entry.hadRecentInput) {
                clsValue += entry.value;
            }
        });
        console.log('CLS:', clsValue);
        markPerformance('cls');
    }).observe({ entryTypes: ['layout-shift'] });
}

// Initialize performance monitoring
if ('PerformanceObserver' in window) {
    reportWebVitals();
}

// DOM content loaded optimization
document.addEventListener('DOMContentLoaded', () => {
    markPerformance('dom_ready');
    
    // Preconnect to external domains for better performance
    const preconnectDomains = [
        'https://fonts.googleapis.com',
        'https://fonts.gstatic.com',
        'https://maps.googleapis.com'
    ];
    
    preconnectDomains.forEach(domain => {
        if (!document.querySelector(`link[href="${domain}"]`)) {
            const link = document.createElement('link');
            link.rel = 'preconnect';
            link.href = domain;
            document.head.appendChild(link);
        }
    });
});

// Service Worker registration for PWA capabilities
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then((registration) => {
                console.log('SW registered: ', registration);
                markPerformance('sw_registered');
            })
            .catch((registrationError) => {
                console.log('SW registration failed: ', registrationError);
            });
    });
}
