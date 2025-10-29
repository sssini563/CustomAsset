# Snipe-IT Custom Asset Deployment Guide

## Ubuntu Deployment (Native)

### Quick Start
```bash
# Download and run deployment script
sudo bash deploy-ubuntu.sh
```

### Manual Steps After Deployment

1. **Configure Database**
   ```bash
   # Login to MySQL
   sudo mysql -u root -p
   
   # Create database and user
   CREATE DATABASE snipeit CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'snipeit'@'localhost' IDENTIFIED BY 'your_secure_password';
   GRANT ALL PRIVILEGES ON snipeit.* TO 'snipeit'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

2. **Update .env file**
   ```bash
   cd /var/www/snipe-it
   sudo nano .env
   ```
   
   Update these values:
   ```
   APP_URL=http://your-domain.com
   DB_DATABASE=snipeit
   DB_USERNAME=snipeit
   DB_PASSWORD=your_secure_password
   ```

3. **Run Migrations**
   ```bash
   cd /var/www/snipe-it
   php artisan migrate
   php artisan db:seed
   ```

4. **Create First Admin User**
   ```bash
   php artisan snipeit:user --first_name=Admin --username=admin --email=admin@example.com --password=admin123
   ```

---

## Docker Deployment

### Quick Start
```bash
# Download and run Docker deployment script
sudo bash deploy-docker.sh
```

### Manual Docker Setup

1. **Build and Start Containers**
   ```bash
   docker-compose up -d --build
   ```

2. **Run Migrations**
   ```bash
   docker-compose exec app php artisan migrate --force
   docker-compose exec app php artisan db:seed --force
   ```

3. **Create Admin User**
   ```bash
   docker-compose exec app php artisan snipeit:user \
     --first_name=Admin \
     --username=admin \
     --email=admin@example.com \
     --password=admin123
   ```

### Useful Docker Commands
```bash
# View logs
docker-compose logs -f app

# Access container shell
docker-compose exec app bash

# Restart services
docker-compose restart

# Stop all services
docker-compose down

# Stop and remove volumes
docker-compose down -v
```

---

## Update Existing Installation

### Native Ubuntu
```bash
sudo bash update.sh
```

### Docker
```bash
git pull origin main
docker-compose down
docker-compose up -d --build
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan cache:clear
```

---

## System Requirements

### Minimum Requirements
- Ubuntu 20.04 LTS or newer
- PHP 8.1+ (8.3 recommended)
- MySQL 5.7+ or MariaDB 10.2+
- Nginx or Apache
- 2GB RAM minimum
- 10GB disk space

### Recommended Requirements
- Ubuntu 22.04 LTS
- PHP 8.3
- MySQL 8.0
- 4GB RAM
- 20GB disk space
- Redis for caching

---

## Troubleshooting

### Permission Issues
```bash
cd /var/www/snipe-it
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
sudo chmod -R 775 public/uploads
```

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
```

### Database Issues
```bash
# Check database connection
php artisan tinker
DB::connection()->getPdo();

# Reset migrations (WARNING: destroys data)
php artisan migrate:fresh --seed
```

### Nginx Not Starting
```bash
# Test configuration
sudo nginx -t

# Check error logs
sudo tail -f /var/log/nginx/error.log

# Restart Nginx
sudo systemctl restart nginx
```

### PHP-FPM Issues
```bash
# Check PHP-FPM status
sudo systemctl status php8.3-fpm

# Restart PHP-FPM
sudo systemctl restart php8.3-fpm

# Check logs
sudo tail -f /var/log/php8.3-fpm.log
```

---

## Production Optimization

### Enable OPcache
Edit `/etc/php/8.3/fpm/php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

### Setup SSL with Let's Encrypt
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d your-domain.com
```

### Setup Cron Jobs
```bash
sudo crontab -e
```
Add:
```
* * * * * cd /var/www/snipe-it && php artisan schedule:run >> /dev/null 2>&1
```

### Setup Queue Worker
Create `/etc/supervisor/conf.d/snipeit-worker.conf`:
```ini
[program:snipeit-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/snipe-it/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/snipe-it/storage/logs/worker.log
```

Then:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start snipeit-worker:*
```

---

## Backup & Restore

### Backup
```bash
# Database backup
mysqldump -u snipeit -p snipeit > backup_$(date +%Y%m%d).sql

# Files backup
tar -czf snipeit_files_$(date +%Y%m%d).tar.gz /var/www/snipe-it
```

### Restore
```bash
# Restore database
mysql -u snipeit -p snipeit < backup_20250129.sql

# Restore files
tar -xzf snipeit_files_20250129.tar.gz -C /
```

---

## Support

For issues or questions, check:
- GitHub: https://github.com/sssini563/CustomAsset
- Snipe-IT Documentation: https://snipe-it.readme.io/
