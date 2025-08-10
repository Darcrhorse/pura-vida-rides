/**
 * Lighthouse CI Configuration for Pura Vida Rides
 * Defines performance budgets and CI rules
 */

module.exports = {
  ci: {
    collect: {
      // URLs to test
      url: [
        'http://localhost:8000/',
        'http://localhost:8000/trips',
        'http://localhost:8000/login',
        'http://localhost:8000/register'
      ],
      // Collection settings
      numberOfRuns: 3,
      settings: {
        chromeFlags: '--no-sandbox --disable-dev-shm-usage',
        preset: 'desktop',
        throttling: {
          rttMs: 40,
          throughputKbps: 10 * 1024,
          cpuSlowdownMultiplier: 1,
          requestLatencyMs: 0,
          downloadThroughputKbps: 0,
          uploadThroughputKbps: 0
        },
        screenEmulation: {
          mobile: false,
          width: 1350,
          height: 940,
          deviceScaleFactor: 1,
          disabled: false
        }
      }
    },
    assert: {
      // Performance budgets and thresholds
      assertions: {
        // Core Web Vitals
        'largest-contentful-paint': ['error', { maxNumericValue: 2500 }],
        'first-contentful-paint': ['error', { maxNumericValue: 1800 }],
        'cumulative-layout-shift': ['error', { maxNumericValue: 0.1 }],
        'total-blocking-time': ['error', { maxNumericValue: 300 }],
        
        // Performance metrics
        'speed-index': ['error', { maxNumericValue: 3000 }],
        'interactive': ['error', { maxNumericValue: 3800 }],
        'first-meaningful-paint': ['error', { maxNumericValue: 2000 }],
        
        // Category scores (0-1 scale)
        'categories:performance': ['error', { minScore: 0.9 }],
        'categories:accessibility': ['error', { minScore: 0.95 }],
        'categories:best-practices': ['error', { minScore: 0.9 }],
        'categories:seo': ['error', { minScore: 0.9 }],
        'categories:pwa': ['warn', { minScore: 0.8 }],
        
        // Resource optimization
        'resource-summary:script:size': ['error', { maxNumericValue: 200000 }], // 200KB
        'resource-summary:stylesheet:size': ['error', { maxNumericValue: 100000 }], // 100KB
        'resource-summary:image:size': ['error', { maxNumericValue: 500000 }], // 500KB
        'resource-summary:font:size': ['error', { maxNumericValue: 150000 }], // 150KB
        
        // Network requests
        'resource-summary:total:count': ['warn', { maxNumericValue: 50 }],
        'resource-summary:script:count': ['warn', { maxNumericValue: 10 }],
        'resource-summary:stylesheet:count': ['warn', { maxNumericValue: 5 }],
        
        // Specific audits
        'unused-css-rules': ['warn', { maxNumericValue: 20000 }],
        'unused-javascript': ['warn', { maxNumericValue: 30000 }],
        'modern-image-formats': 'error',
        'offscreen-images': 'error',
        'render-blocking-resources': 'error',
        'unminified-css': 'error',
        'unminified-javascript': 'error',
        'efficient-animated-content': 'error',
        'uses-long-cache-ttl': 'warn',
        'uses-optimized-images': 'error',
        'uses-responsive-images': 'error',
        'uses-text-compression': 'error',
        
        // Accessibility
        'color-contrast': 'error',
        'image-alt': 'error',
        'label': 'error',
        'link-name': 'error',
        'meta-viewport': 'error',
        'heading-order': 'error',
        'landmark-one-main': 'error',
        'focus-traps': 'error',
        'focusable-controls': 'error',
        'interactive-element-affordance': 'error',
        'logical-tab-order': 'error',
        'managed-focus': 'error',
        'use-landmarks': 'error',
        
        // SEO
        'document-title': 'error',
        'meta-description': 'error',
        'http-status-code': 'error',
        'link-text': 'error',
        'crawlable-anchors': 'error',
        'is-crawlable': 'error',
        'robots-txt': 'warn',
        'hreflang': 'warn',
        'canonical': 'warn',
        
        // Best Practices
        'is-on-https': 'error',
        'uses-http2': 'warn',
        'no-vulnerable-libraries': 'error',
        'external-anchors-use-rel-noopener': 'error',
        'geolocation-on-start': 'error',
        'notification-on-start': 'error',
        'no-document-write': 'error',
        'no-unload-listeners': 'error',
        'appcache-manifest': 'error',
        'doctype': 'error'
      }
    },
    upload: {
      // Configure where to store results (can be GitHub, filesystem, etc.)
      target: 'filesystem',
      outputDir: './lighthouse-reports',
      reportFilenamePattern: '%%DATETIME%%-%%PATHNAME%%-report.%%EXTENSION%%'
    },
    server: {
      // If you need to start a server before testing
      // command: 'php artisan serve',
      // port: 8000
    }
  }
};