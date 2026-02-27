#!/bin/bash
set -e

APP_DIR="/var/www/breefondation"

echo ">>> Taking ownership for deploy..."
sudo chown -R $USER:www-data "$APP_DIR"

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

echo ">>> Restarting queue workers..."
php artisan queue:restart

echo ">>> Setting file permissions..."
sudo find "$APP_DIR" -type f -exec chmod 644 {} \;
sudo find "$APP_DIR" -type d -exec chmod 755 {} \;
sudo chmod -R 775 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
sudo chown -R www-data:www-data "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"

echo ">>> Restarting PHP-FPM..."
sudo systemctl restart php8.4-fpm

echo ">>> Reloading Nginx..."
sudo systemctl reload nginx

echo ">>> Done! Deployment complete."
