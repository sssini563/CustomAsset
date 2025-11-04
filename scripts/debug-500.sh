#!/bin/bash
# Script untuk debug error 500 di server Ubuntu
# Run: bash debug-500.sh

echo "=== Checking Docker Containers ==="
docker ps -a

echo -e "\n=== Checking App Container Logs (last 50 lines) ==="
docker logs --tail 50 snipe-app 2>&1 || docker logs --tail 50 $(docker ps -q --filter ancestor=snipe/snipe-it) 2>&1

echo -e "\n=== Checking Laravel Logs ==="
docker exec snipe-app tail -50 /var/www/html/storage/logs/laravel.log 2>&1 || echo "Could not read laravel.log"

echo -e "\n=== Checking File Permissions ==="
docker exec snipe-app ls -la /var/www/html/ | head -20
docker exec snipe-app ls -la /var/www/html/storage/
docker exec snipe-app ls -la /var/www/html/bootstrap/cache/

echo -e "\n=== Checking .env File ==="
docker exec snipe-app test -f /var/www/html/.env && echo ".env exists" || echo ".env MISSING!"

echo -e "\n=== Checking APP_KEY ==="
docker exec snipe-app grep "APP_KEY=" /var/www/html/.env || echo "APP_KEY not set!"

echo -e "\n=== Common Fixes ==="
echo "1. Fix permissions:"
echo "   docker exec -u root snipe-app chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache"
echo "   docker exec -u root snipe-app chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
echo ""
echo "2. Clear caches:"
echo "   docker exec snipe-app php artisan config:clear"
echo "   docker exec snipe-app php artisan cache:clear"
echo "   docker exec snipe-app php artisan view:clear"
echo ""
echo "3. Check .env:"
echo "   docker exec snipe-app cat /var/www/html/.env | grep -E '(APP_KEY|DB_|REDIS_)'"
