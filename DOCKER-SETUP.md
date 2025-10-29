# Docker Deployment - Quick Start

## Setup Langsung di Ubuntu

### 1. Clone Repository
```bash
git clone https://github.com/sssini563/CustomAsset.git
cd CustomAsset
```

### 2. Setup Environment File
```bash
# Copy dan edit .env
cp .env.example .env
nano .env

# Pastikan setting ini:
DB_HOST=db
DB_DATABASE=snipeit
DB_USERNAME=snipeit
DB_PASSWORD=snipeit_password
REDIS_HOST=redis
```

### 3. Generate APP_KEY
```bash
# Install PHP dulu kalau belum ada
sudo apt install php-cli -y

# Generate key
php artisan key:generate
```

### 4. Build dan Start Containers
```bash
# Build images
docker-compose build

# Start all services
docker-compose up -d

# Check logs
docker-compose logs -f
```

### 5. Setup Database
```bash
# Tunggu database ready (30 detik)
sleep 30

# Run migrations
docker-compose exec app php artisan migrate --force

# Create admin user (optional)
docker-compose exec app php artisan snipeit:user \
  --first_name=Admin \
  --username=admin \
  --email=admin@example.com \
  --password=admin123
```

### 6. Access Application
```
http://your-server-ip:8080
```

---

## Quick Commands

### Start Services
```bash
docker-compose up -d
```

### Stop Services
```bash
docker-compose down
```

### View Logs
```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f db
```

### Access Container Shell
```bash
# App container
docker-compose exec app bash

# Database
docker-compose exec db mysql -u snipeit -p
```

### Restart Services
```bash
docker-compose restart
```

### Rebuild After Code Changes
```bash
git pull origin main
docker-compose down
docker-compose build --no-cache
docker-compose up -d
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan cache:clear
```

---

## Edit Konfigurasi

### docker-compose.yml
```bash
nano docker-compose.yml

# Ports yang bisa diubah:
# - "8080:80"     # Nginx web port
# - "3306:3306"   # MySQL port
# - "6379:6379"   # Redis port

# Restart setelah edit
docker-compose down
docker-compose up -d
```

### .env
```bash
nano .env

# Setting penting:
# APP_URL=http://your-domain.com
# DB_HOST=db (jangan diubah, ini nama service)
# DB_DATABASE=snipeit
# DB_USERNAME=snipeit
# DB_PASSWORD=snipeit_password (ganti dengan password kuat)

# Restart app setelah edit
docker-compose restart app
```

### Nginx Configuration
```bash
nano docker/nginx.conf

# Restart nginx setelah edit
docker-compose restart nginx
```

---

## Troubleshooting

### Container tidak start
```bash
# Check status
docker-compose ps

# Check logs
docker-compose logs app
docker-compose logs db
```

### Permission errors
```bash
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```

### Database connection failed
```bash
# Check database ready
docker-compose exec db mysql -u root -proot_password -e "SHOW DATABASES;"

# Reset database (WARNING: deletes all data)
docker-compose down -v
docker-compose up -d
sleep 30
docker-compose exec app php artisan migrate --force
```

### Clear all caches
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

---

## Production Tips

### 1. Use Strong Passwords
Edit `.env`:
```
DB_PASSWORD=use_very_strong_password_here
```

Edit `docker-compose.yml`:
```yaml
MYSQL_ROOT_PASSWORD: use_different_strong_password
MYSQL_PASSWORD: same_as_env_db_password
```

### 2. Setup SSL with Nginx Proxy
```bash
# Install nginx-proxy
docker run -d -p 80:80 -p 443:443 \
  --name nginx-proxy \
  -v /var/run/docker.sock:/tmp/docker.sock:ro \
  jwilder/nginx-proxy

# Install letsencrypt companion
docker run -d \
  --name nginx-proxy-letsencrypt \
  --volumes-from nginx-proxy \
  -v /var/run/docker.sock:/var/run/docker.sock:ro \
  jrcs/letsencrypt-nginx-proxy-companion
```

### 3. Backup Database
```bash
# Backup
docker-compose exec db mysqldump -u snipeit -psnipeit_password snipeit > backup_$(date +%Y%m%d).sql

# Restore
docker-compose exec -T db mysql -u snipeit -psnipeit_password snipeit < backup_20250129.sql
```

### 4. Auto-start on Boot
```bash
# Add to docker-compose.yml (already configured)
restart: unless-stopped
```

---

## Resource Requirements

**Minimum:**
- 2 CPU cores
- 4GB RAM
- 20GB disk space

**Recommended:**
- 4 CPU cores
- 8GB RAM
- 50GB SSD

---

## Support

- GitHub: https://github.com/sssini563/CustomAsset
- Docker Hub: https://hub.docker.com/_/mysql
- Nginx: https://nginx.org/en/docs/
