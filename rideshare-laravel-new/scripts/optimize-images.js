/**
 * Image Optimization Script for Pura Vida Rides
 * Converts images to multiple formats and sizes for responsive loading
 */

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import imagemin from 'imagemin';
import imageminMozjpeg from 'imagemin-mozjpeg';
import imageminPngquant from 'imagemin-pngquant';
import imageminWebp from 'imagemin-webp';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Paths
const SOURCE_DIR = path.join(__dirname, '../../../IMAGES');
const OUTPUT_DIR = path.join(__dirname, '../public/images');
const OPTIMIZED_DIR = path.join(OUTPUT_DIR, 'optimized');
const WEBP_DIR = path.join(OUTPUT_DIR, 'webp');

// Responsive breakpoints
const BREAKPOINTS = {
    sm: 640,
    md: 768,
    lg: 1024,
    xl: 1280,
    full: 1920
};

// Image categories and their optimizations
const IMAGE_CATEGORIES = {
    hero: {
        quality: 85,
        progressive: true,
        sizes: ['md', 'lg', 'xl', 'full']
    },
    card: {
        quality: 80,
        progressive: false,
        sizes: ['sm', 'md', 'lg']
    },
    thumbnail: {
        quality: 75,
        progressive: false,
        sizes: ['sm', 'md']
    },
    illustration: {
        quality: 90,
        progressive: false,
        sizes: ['sm', 'md', 'lg', 'xl']
    },
    default: {
        quality: 80,
        progressive: true,
        sizes: ['sm', 'md', 'lg', 'xl']
    }
};

class ImageOptimizer {
    constructor() {
        this.processedCount = 0;
        this.totalImages = 0;
        this.categories = this.detectImageCategories();
    }

    detectImageCategories() {
        const categories = {};
        
        // Define category patterns
        const patterns = {
            hero: /hero|banner|header|cinematic|wide/i,
            card: /card|compact|interior|driver/i,
            thumbnail: /thumb|small|icon/i,
            illustration: /illustration|minimal|vector|three-panel/i
        };

        // Scan source directory
        if (!fs.existsSync(SOURCE_DIR)) {
            console.log('📁 Source IMAGES directory not found, creating sample mapping...');
            return { default: IMAGE_CATEGORIES.default };
        }

        const files = fs.readdirSync(SOURCE_DIR);
        
        files.forEach(file => {
            const fileName = file.toLowerCase();
            let category = 'default';
            
            for (const [cat, pattern] of Object.entries(patterns)) {
                if (pattern.test(fileName)) {
                    category = cat;
                    break;
                }
            }
            
            categories[file] = IMAGE_CATEGORIES[category];
        });

        console.log(`📊 Detected ${Object.keys(categories).length} images across categories`);
        return categories;
    }

    async createDirectories() {
        const dirs = [OUTPUT_DIR, OPTIMIZED_DIR, WEBP_DIR];
        
        for (const dir of dirs) {
            if (!fs.existsSync(dir)) {
                fs.mkdirSync(dir, { recursive: true });
                console.log(`📁 Created directory: ${path.relative(__dirname, dir)}`);
            }
        }
    }

    async optimizeImages() {
        console.log('🚀 Starting image optimization...');
        
        await this.createDirectories();
        
        if (!fs.existsSync(SOURCE_DIR)) {
            console.log('⚠️  Source IMAGES directory not found. Creating optimized versions of existing images...');
            await this.optimizeExistingImages();
            return;
        }

        const files = fs.readdirSync(SOURCE_DIR).filter(file => 
            /\.(jpg|jpeg|png|webp)$/i.test(file)
        );

        this.totalImages = files.length;
        console.log(`📸 Found ${this.totalImages} images to optimize`);

        for (const file of files) {
            await this.processImage(file);
        }

        console.log(`✅ Optimization complete! Processed ${this.processedCount}/${this.totalImages} images`);
        await this.generateImageManifest();
    }

    async optimizeExistingImages() {
        // Optimize existing images in public/images
        const existingImages = [
            'hero-index.jpg',
            'results-strip.jpg',
            'auth-illustration.jpg',
            'booking-banner.jpg',
            'offer-ride-hero.jpg'
        ];

        for (const image of existingImages) {
            const sourcePath = path.join(OUTPUT_DIR, image);
            if (fs.existsSync(sourcePath)) {
                await this.processExistingImage(image);
            }
        }
    }

    async processImage(filename) {
        const sourcePath = path.join(SOURCE_DIR, filename);
        const category = this.categories[filename] || IMAGE_CATEGORIES.default;
        const baseName = path.parse(filename).name;
        const ext = path.parse(filename).ext.toLowerCase();

        console.log(`🔄 Processing: ${filename}`);

        try {
            // Generate responsive sizes
            for (const size of category.sizes) {
                const width = BREAKPOINTS[size];
                const outputName = `${baseName}_${size}${ext}`;
                const outputPath = path.join(OPTIMIZED_DIR, outputName);

                // Optimize original format
                await this.optimizeToFormat(sourcePath, outputPath, ext, category.quality, width);

                // Generate WebP version
                const webpName = `${baseName}_${size}.webp`;
                const webpPath = path.join(WEBP_DIR, webpName);
                await this.optimizeToWebP(sourcePath, webpPath, category.quality, width);
            }

            this.processedCount++;
            console.log(`✓ Completed: ${filename} (${this.processedCount}/${this.totalImages})`);

        } catch (error) {
            console.error(`❌ Failed to process ${filename}:`, error.message);
        }
    }

    async processExistingImage(filename) {
        const sourcePath = path.join(OUTPUT_DIR, filename);
        const baseName = path.parse(filename).name;
        const ext = path.parse(filename).ext.toLowerCase();
        const category = IMAGE_CATEGORIES.hero; // Assume hero category for existing images

        console.log(`🔄 Processing existing: ${filename}`);

        try {
            for (const size of category.sizes) {
                const width = BREAKPOINTS[size];
                const outputName = `${baseName}_${size}${ext}`;
                const outputPath = path.join(OPTIMIZED_DIR, outputName);

                await this.optimizeToFormat(sourcePath, outputPath, ext, category.quality, width);

                const webpName = `${baseName}_${size}.webp`;
                const webpPath = path.join(WEBP_DIR, webpName);
                await this.optimizeToWebP(sourcePath, webpPath, category.quality, width);
            }

            console.log(`✓ Completed existing: ${filename}`);

        } catch (error) {
            console.error(`❌ Failed to process existing ${filename}:`, error.message);
        }
    }

    async optimizeToFormat(inputPath, outputPath, format, quality, maxWidth) {
        const plugins = [];

        if (format === '.jpg' || format === '.jpeg') {
            plugins.push(imageminMozjpeg({ 
                quality,
                progressive: true 
            }));
        } else if (format === '.png') {
            plugins.push(imageminPngquant({ 
                quality: [quality/100 - 0.1, quality/100],
                strip: true
            }));
        }

        if (plugins.length === 0) return;

        await imagemin([inputPath], path.dirname(outputPath), {
            plugins,
            destination: path.dirname(outputPath)
        });

        // Rename to target filename
        const tempName = path.join(path.dirname(outputPath), path.basename(inputPath));
        if (fs.existsSync(tempName) && tempName !== outputPath) {
            fs.renameSync(tempName, outputPath);
        }
    }

    async optimizeToWebP(inputPath, outputPath, quality, maxWidth) {
        await imagemin([inputPath], path.dirname(outputPath), {
            plugins: [
                imageminWebp({ 
                    quality,
                    method: 6,
                    autoFilter: true,
                    sharpness: 4
                })
            ]
        });

        // Rename to target filename
        const baseName = path.parse(path.basename(inputPath)).name;
        const tempName = path.join(path.dirname(outputPath), `${baseName}.webp`);
        if (fs.existsSync(tempName) && tempName !== outputPath) {
            fs.renameSync(tempName, outputPath);
        }
    }

    async generateImageManifest() {
        const manifest = {
            generated: new Date().toISOString(),
            breakpoints: BREAKPOINTS,
            categories: IMAGE_CATEGORIES,
            optimized: [],
            webp: []
        };

        // Scan optimized directory
        if (fs.existsSync(OPTIMIZED_DIR)) {
            manifest.optimized = fs.readdirSync(OPTIMIZED_DIR);
        }

        // Scan WebP directory
        if (fs.existsSync(WEBP_DIR)) {
            manifest.webp = fs.readdirSync(WEBP_DIR);
        }

        const manifestPath = path.join(OUTPUT_DIR, 'image-manifest.json');
        fs.writeFileSync(manifestPath, JSON.stringify(manifest, null, 2));

        console.log(`📋 Generated image manifest: ${manifest.optimized.length} optimized, ${manifest.webp.length} WebP images`);
    }
}

// Run optimization
const optimizer = new ImageOptimizer();
optimizer.optimizeImages()
    .then(() => {
        console.log('🎉 Image optimization completed successfully!');
        process.exit(0);
    })
    .catch((error) => {
        console.error('💥 Image optimization failed:', error);
        process.exit(1);
    });