# 🚀 Pura Vida Rides - Deployment Guide

## Prerequisites
- Node.js 20.19.0+ or 22.12.0+ (current warnings about Node.js version)
- PHP 8.2+
- Composer
- Laravel 11
- Google Maps API Key

## 📋 Deployment Steps

### Step 1: ✅ Install Dependencies (Currently Running)
```bash
cd rideshare-laravel-new
npm install
```
**Status**: Currently running - wait for completion before proceeding.

### Step 2: Build for Production
Once npm install completes, run:
```bash
npm run build:prod
```
This will:
- Minify JavaScript and CSS
- Optimize assets for production
- Generate optimized build files in `public/build`

### Step 3: Image Optimization (Optional)
If you want to optimize images from the IMAGES folder:
```bash
npm run optimize:images
```
Or manually run:
```bash
node scripts/optimize-images.js
```

### Step 4: Laravel Environment Setup
1. **Copy environment file**:
```bash
cp .env.example .env
```

2. **Generate application key**:
```bash
php artisan key:generate
```

3. **Configure environment variables** in `.env`:
```env
APP_NAME="Pura Vida Rides"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pura_vida_rides
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Google Maps API
GOOGLE_MAPS_API_KEY=your_google_maps_api_key_here

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-mail-username
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@puravidarides.com
MAIL_FROM_NAME="Pura Vida Rides"
```

### Step 5: Database Migration
```bash
php artisan migrate
```

### Step 6: Run Performance Tests
After successful build, test performance:
```bash
# Start the Laravel development server
php artisan serve

# In another terminal, if Lighthouse CI was installed:
npm run lighthouse

# Manual Lighthouse testing:
# 1. Open Chrome DevTools
# 2. Go to Lighthouse tab
# 3. Test http://localhost:8000
# 4. Verify scores: Performance > 90, Accessibility > 95, SEO > 90
```

## 🔍 Verification Checklist

### ✅ Frontend Verification
- [ ] Sticky navigation works on scroll
- [ ] Google Places Autocomplete loads
- [ ] Form validation displays correctly
- [ ] Images lazy load properly
- [ ] Mobile navigation responsive
- [ ] Loading states appear during form submissions

### ✅ Performance Verification
- [ ] Lighthouse Performance Score > 90
- [ ] Lighthouse Accessibility Score > 95
- [ ] Lighthouse SEO Score > 90
- [ ] Core Web Vitals within targets:
  - LCP < 2.5s
  - FID < 100ms
  - CLS < 0.1

### ✅ Cross-Browser Testing
Test the following in each browser:
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Chrome (Android)
- [ ] Mobile Safari (iOS)

### ✅ Responsive Testing
Test at these breakpoints:
- [ ] 320px (small mobile)
- [ ] 375px (mobile)
- [ ] 768px (tablet)
- [ ] 1024px (desktop)
- [ ] 1440px (large desktop)

## 🚨 Troubleshooting

### Common Issues & Solutions

**1. Node.js Version Warnings**
```
npm WARN EBADENGINE Unsupported engine
```
**Solution**: Upgrade Node.js to 20.19.0+ or use `--legacy-peer-deps`:
```bash
npm install --legacy-peer-deps
```

**2. Vite Build Errors**
```
Error: Cannot resolve module
```
**Solution**: Clear cache and reinstall:
```bash
npm run clean
rm -rf node_modules package-lock.json
npm install
npm run build
```

**3. Google Places API Not Loading**
**Solution**: Check in `.env` file:
- API key is correct
- API has Places Library enabled
- Domain is authorized in Google Cloud Console

**4. Images Not Loading**
**Solution**: 
- Check public/images folder exists
- Run `php artisan storage:link` if using storage
- Verify file permissions

**5. Service Worker Not Registering**
**Solution**:
- Ensure serving over HTTPS in production
- Check console for registration errors
- Verify `sw.js` is accessible at root

## 📊 Performance Monitoring

### Key Metrics to Track
- **Page Load Time**: < 3 seconds
- **First Contentful Paint**: < 2 seconds  
- **Largest Contentful Paint**: < 2.5 seconds
- **Cumulative Layout Shift**: < 0.1
- **First Input Delay**: < 100ms

### Monitoring Tools
- Google PageSpeed Insights
- Chrome DevTools Lighthouse
- WebPageTest
- Real User Monitoring (RUM)

## 🔄 Continuous Integration

### GitHub Actions Example
```yaml
name: Deploy Pura Vida Rides
on: [push, pull_request]
jobs:
  test-performance:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup Node.js
        uses: actions/setup-node@v2
        with:
          node-version: '20.19'
      - name: Install dependencies
        run: npm install
      - name: Build for production
        run: npm run build:prod
      - name: Run Lighthouse CI
        run: npm run lighthouse
```

## 🎯 Production Checklist

Before deploying to production:
- [ ] All tests pass
- [ ] Performance scores meet targets
- [ ] Error monitoring set up
- [ ] SSL certificate installed
- [ ] CDN configured (if applicable)
- [ ] Database backups configured
- [ ] Monitoring alerts configured
- [ ] DNS configured correctly

## 📞 Support

For technical issues:
1. Check browser console for errors
2. Verify all environment variables
3. Test in incognito/private mode
4. Check network requests in DevTools
5. Review Laravel logs in `storage/logs`

---

## 🎉 Success Criteria

The deployment is successful when:
- ✅ Site loads in < 3 seconds
- ✅ All interactive elements work
- ✅ Forms submit successfully
- ✅ Mobile experience is smooth
- ✅ Lighthouse scores meet targets
- ✅ No console errors
- ✅ All browsers tested successfully

**Next Steps**: Monitor performance metrics and user feedback for continuous improvement.