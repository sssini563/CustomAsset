#!/bin/bash
# Script untuk fix error 500 - jalankan ini di server Ubuntu
# Usage: bash fix-500-error.sh

set -e

echo "=== Fixing 500 Error - Snipe-IT Docker ==="
echo ""

# Get container name
CONTAINER=$(docker ps -q --filter ancestor=snipe/snipe-it | head -1)
if [ -z "$CONTAINER" ]; then
    CONTAINER="snipe-app"
fi

echo "Using container: $CONTAINER"
echo ""

echo "1. Fixing file permissions..."
docker exec -u root $CONTAINER chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
docker exec -u root $CONTAINER chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
docker exec -u root $CONTAINER chmod +x /var/www/html/artisan 2>/dev/null || true
echo "✓ Permissions fixed"

echo ""
echo "2. Clearing Laravel caches..."
docker exec $CONTAINER php artisan config:clear 2>/dev/null || echo "  - config:clear skipped"
docker exec $CONTAINER php artisan cache:clear 2>/dev/null || echo "  - cache:clear skipped"
docker exec $CONTAINER php artisan view:clear 2>/dev/null || echo "  - view:clear skipped"
docker exec $CONTAINER php artisan route:clear 2>/dev/null || echo "  - route:clear skipped"
echo "✓ Caches cleared"

echo ""
echo "3. Checking .env file..."
if docker exec $CONTAINER test -f /var/www/html/.env; then
    echo "✓ .env exists"
    
    # Check APP_KEY
    if docker exec $CONTAINER grep -q "APP_KEY=base64:" /var/www/html/.env; then
        echo "✓ APP_KEY is set"
    else
        echo "⚠ APP_KEY not set! Generating..."
        docker exec $CONTAINER php artisan key:generate --force
    fi
    
    # Check Redis host for production
    REDIS_HOST=$(docker exec $CONTAINER grep "REDIS_HOST=" /var/www/html/.env | cut -d'=' -f2)
    if [ "$REDIS_HOST" = "127.0.0.1" ]; then
        echo "⚠ REDIS_HOST is 127.0.0.1 - should be 'redis' in Docker!"
        echo "  Run: docker exec $CONTAINER sed -i 's/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/' /var/www/html/.env"
        echo "  Then: docker-compose restart app"
    else
        echo "✓ REDIS_HOST looks correct: $REDIS_HOST"
    fi
else
    echo "✗ .env file NOT FOUND!"
    echo "  Copy .env.example to .env and configure it"
    exit 1
fi

echo ""
echo "4. Testing artisan..."
if docker exec $CONTAINER php artisan --version > /dev/null 2>&1; then
    echo "✓ Artisan works"
else
    echo "✗ Artisan failed - check logs"
fi

echo ""
echo "5. Checking database connection..."
if docker exec $CONTAINER php artisan db:show > /dev/null 2>&1; then
    echo "✓ Database connected"
else
    echo "⚠ Database connection issue - check DB_* in .env"
fi

echo ""
echo "=== Restart container to apply all fixes ==="
echo "Run: docker-compose restart app"
echo ""
echo "If still error 500, check logs:"
echo "  docker logs snipe-app --tail 100"
echo "  docker exec snipe-app tail -100 /var/www/html/storage/logs/laravel.log"
