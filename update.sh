#!/bin/bash

# =====================================================
# Snipe-IT Quick Update Script
# =====================================================

set -e

APP_DIR="/var/www/snipe-it"

echo "Updating Snipe-IT..."

cd $APP_DIR

# Put application in maintenance mode
php artisan down

# Pull latest changes
git pull origin main

# Update dependencies
composer install --no-dev --optimize-autoloader

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Run migrations
php artisan migrate --force

# Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chown -R www-data:www-data $APP_DIR
chmod -R 775 $APP_DIR/storage
chmod -R 775 $APP_DIR/bootstrap/cache

# Bring application back online
php artisan up

echo "Update complete!"
