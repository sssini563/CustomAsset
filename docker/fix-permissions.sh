#!/bin/bash
set -e

echo "=== Fixing Permissions ==="

# Check if vendor directory is empty and install dependencies
if [ ! -d "/var/www/html/vendor/laravel" ]; then
    echo "Vendor directory is empty or incomplete. Installing dependencies..."
    cd /var/www/html
    composer install --no-dev --optimize-autoloader --no-interaction || echo "Composer install failed, continuing..."
fi

echo "Creating framework directories..."
mkdir -p /var/www/html/storage/framework/{sessions,views,cache,testing}
mkdir -p /var/www/html/bootstrap/cache

echo "Creating upload directories..."
mkdir -p /var/www/html/public/uploads/{accessories,assets,avatars,barcodes,categories,companies,components,consumables,departments,eula-pdfs,imports,licenses,locations,manufacturers,models,suppliers,users}
mkdir -p /var/www/html/storage/app/private_uploads/{accessories,assets,assetmodels,categories,companies,components,consumables,departments,imports,licenses,locations,manufacturers,suppliers,users}

echo "Creating storage link..."
cd /var/www/html
php artisan storage:link 2>/dev/null || echo "Storage link already exists"

echo "Detecting user and group..."
# Detect user (docker or www-data)
if id -u docker >/dev/null 2>&1; then
    APP_USER="docker"
    # Detect group (staff, www-data, or docker's primary group)
    if getent group staff >/dev/null 2>&1; then
        APP_GROUP="staff"
    elif getent group www-data >/dev/null 2>&1; then
        APP_GROUP="www-data"
    else
        APP_GROUP=$(id -gn docker)
    fi
elif id -u www-data >/dev/null 2>&1; then
    APP_USER="www-data"
    APP_GROUP="www-data"
else
    APP_USER="root"
    APP_GROUP="root"
fi

echo "Using user: $APP_USER, group: $APP_GROUP"

echo "Setting ownership..."
chown -R $APP_USER:$APP_GROUP /var/www/html/storage
chown -R $APP_USER:$APP_GROUP /var/www/html/bootstrap/cache
chown -R $APP_USER:$APP_GROUP /var/www/html/public/uploads

echo "Setting permissions..."
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/public/uploads
chmod +x /var/www/html/artisan

echo "=== Permissions Fixed ==="
echo "Verifying ownership..."
ls -la /var/www/html/storage/framework/views/ 2>/dev/null || echo "Views directory ready"

echo "=== Starting Application ==="
exec /startup.sh
