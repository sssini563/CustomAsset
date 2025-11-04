#!/bin/bash
set -e

echo "=========================================="
echo "Starting Snipe-IT Custom Build"
echo "=========================================="

# Change to working directory
cd /var/www/html

# Override .env with environment variables
echo "Configuring environment..."
sed -i "s|DB_HOST=.*|DB_HOST=${DB_HOST}|" .env
sed -i "s|DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|" .env
sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" .env
sed -i "s|DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" .env
# Set timezone jika kosong
if [ -z "${APP_TIMEZONE}" ]; then
  sed -i "s|APP_TIMEZONE=.*|APP_TIMEZONE=Asia/Jakarta|" .env
else
  sed -i "s|APP_TIMEZONE=.*|APP_TIMEZONE=${APP_TIMEZONE}|" .env
fi

# Wait for database
echo "Waiting for database..."
RETRIES=30
until mysql -h"${DB_HOST}" -P"${DB_PORT}" -u"${DB_USERNAME}" -p"${DB_PASSWORD}" --skip-ssl -e "SELECT 1" >/dev/null 2>&1 || [ $RETRIES -eq 0 ]; do
    echo "Waiting for database, $((RETRIES--)) remaining attempts..."
    sleep 2
done

if [ $RETRIES -eq 0 ]; then
    echo "ERROR: Database connection failed!"
    exit 1
fi

echo "Database is ready!"

# Clear stale caches and regenerate package manifest to avoid boot issues
echo "Clearing caches and regenerating package manifest..."
php -d memory_limit=-1 artisan down || true
rm -f bootstrap/cache/config.php bootstrap/cache/packages.php bootstrap/cache/services.php || true
php -d memory_limit=-1 artisan package:discover --ansi || true
php -d memory_limit=-1 artisan config:clear || true
php -d memory_limit=-1 artisan view:clear || true
php -d memory_limit=-1 artisan up || true

# Run migrations (skip if SKIP_AUTORUN_MIGRATIONS is set)
if [ "${SKIP_AUTORUN_MIGRATIONS}" != "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || echo "Migration failed, continuing anyway..."
fi

# Skip all caching - causes hangs
echo "Skipping cache optimization (run manually if needed)..."

echo "=========================================="
echo "Snipe-IT is ready!"
echo "=========================================="

# Start Apache in foreground
exec apache2-foreground
