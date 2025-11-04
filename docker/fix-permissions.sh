#!/bin/bash
set -e

echo "=== Fixing Permissions ==="
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chmod +x /var/www/html/artisan

echo "=== Permissions Fixed ==="
ls -la /var/www/html/storage/framework/views/ | head -5

echo "=== Starting Application ==="
exec /startup.sh
