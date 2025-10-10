#!/bin/bash
set -e

PORT=${PORT:-8080}

echo "Starting Apache on port $PORT"

# Configure Apache port
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf

# Fix Vite manifest location
echo "Checking Vite manifest..."
if [ -f public/build/.vite/manifest.json ]; then
    echo "Copying Vite manifest to correct location..."
    cp public/build/.vite/manifest.json public/build/manifest.json
    echo "Manifest copied successfully"
fi

# Build frontend if manifest still missing
if [ ! -f public/build/manifest.json ]; then
    echo "Manifest not found, building frontend assets..."
    npm run build
    # Copy again after build
    if [ -f public/build/.vite/manifest.json ]; then
        cp public/build/.vite/manifest.json public/build/manifest.json
    fi
fi

# Verify manifest exists
if [ -f public/build/manifest.json ]; then
    echo "✓ Vite manifest found"
else
    echo "✗ Warning: Vite manifest still missing"
fi

# Clear Laravel cache
php artisan config:clear
php artisan route:clear  
php artisan view:clear

# Run migrations
php artisan migrate --force

# Cache Laravel config
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Apache..."
apache2-foreground