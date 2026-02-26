#!/bin/bash
set -e

echo ">>> Pulling latest code..."
git pull origin main

echo ">>> Installing composer dependencies..."
composer install --no-dev --optimize-autoloader

echo ">>> Installing npm dependencies & building assets..."
npm ci
npm run build

echo ">>> Clearing all Laravel caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan event:clear

echo ">>> Re-caching for production performance..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo ">>> Running migrations..."
php artisan migrate --force

echo ">>> Restarting queue workers (if any)..."
php artisan queue:restart

echo ">>> Done! Deployment complete."
