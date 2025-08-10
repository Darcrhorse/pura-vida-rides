<?php
/**
 * Laravel development server router for Railway deployment
 * This router script helps PHP built-in server serve static assets correctly
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Serve static assets from public directory
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    // Get the file path
    $file = __DIR__.'/public'.$uri;
    
    // Set appropriate content type
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
    ];
    
    if (isset($mimeTypes[$extension])) {
        header('Content-Type: ' . $mimeTypes[$extension]);
    }
    
    // Set cache headers for assets
    if (in_array($extension, ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot'])) {
        header('Cache-Control: public, max-age=31536000'); // 1 year
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    }
    
    // Serve the file
    readfile($file);
    return true;
}

// Change working directory to public for Laravel
chdir(__DIR__.'/public');

// Fallback to Laravel's index.php for all other requests
require_once __DIR__.'/public/index.php';
