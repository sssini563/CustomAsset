#!/bin/bash

# =====================================================
# Snipe-IT Docker Deployment Script
# =====================================================

set -e

echo "=========================================="
echo "Building Snipe-IT Docker Container"
echo "=========================================="

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "Docker not found. Installing Docker..."
    curl -fsSL https://get.docker.com -o get-docker.sh
    sh get-docker.sh
    rm get-docker.sh
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo "Docker Compose not found. Installing..."
    apt install -y docker-compose
fi

# Remove old docker-compose.yml if exists
if [ -f docker-compose.yml ]; then
    echo "Removing old docker-compose.yml..."
    rm -f docker-compose.yml
fi

# Create new docker-compose.yml
echo "Creating docker-compose.yml..."
cat > docker-compose.yml <<'DOCKER_COMPOSE'
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: snipeit-app
    restart: unless-stopped
    ports:
      - "9000:9000"
    environment:
      APP_ENV: production
      APP_DEBUG: "false"
      APP_URL: http://localhost:8080
      DB_HOST: db
      DB_PORT: 3306
      DB_DATABASE: snipeit
      DB_USERNAME: snipeit
      DB_PASSWORD: snipeit_password
    volumes:
      - ./storage:/var/www/html/storage
      - ./public/uploads:/var/www/html/public/uploads
      - ./bootstrap/cache:/var/www/html/bootstrap/cache
    depends_on:
      - db
      - redis
    networks:
      - snipeit-network

  db:
    image: mysql:8.0
    container_name: snipeit-db
    restart: unless-stopped
    command: --default-authentication-plugin=mysql_native_password
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: snipeit
      MYSQL_USER: snipeit
      MYSQL_PASSWORD: snipeit_password
    volumes:
      - mysql-data:/var/lib/mysql
    networks:
      - snipeit-network

  redis:
    image: redis:alpine
    container_name: snipeit-redis
    restart: unless-stopped
    networks:
      - snipeit-network

  nginx:
    image: nginx:alpine
    container_name: snipeit-nginx
    restart: unless-stopped
    ports:
      - "8080:80"
    volumes:
      - ./docker/nginx.conf:/etc/nginx/conf.d/default.conf:ro
      - ./public:/var/www/html/public:ro
    depends_on:
      - app
    networks:
      - snipeit-network

volumes:
  mysql-data:

networks:
  snipeit-network:
    driver: bridge
DOCKER_COMPOSE

# Remove old Dockerfile if exists
if [ -f Dockerfile ]; then
    echo "Removing old Dockerfile..."
    rm -f Dockerfile
fi

# Create new Dockerfile
echo "Creating Dockerfile..."
cat > Dockerfile <<'DOCKERFILE'
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copy supervisor configuration
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
DOCKERFILE

# Create docker directory for configs
mkdir -p docker

# Create nginx config for Docker
cat > docker/nginx.conf <<'NGINX'
server {
    listen 80;
    server_name _;
    root /var/www/html/public;

    index index.php index.html;

    client_max_body_size 100M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
NGINX

# Create supervisor config
cat > docker/supervisord.conf <<'SUPERVISOR'
[supervisord]
nodaemon=true
user=root

[program:php-fpm]
command=/usr/local/sbin/php-fpm
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0

[program:queue-worker]
command=php /var/www/html/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
stdout_logfile=/var/www/html/storage/logs/queue.log
SUPERVISOR

echo "Building Docker images..."
docker-compose build

echo "Starting containers..."
docker-compose up -d

echo ""
echo "Waiting for database to be ready..."
sleep 10

echo "Running migrations..."
docker-compose exec app php artisan migrate --force

echo ""
echo "=========================================="
echo "Docker deployment complete!"
echo "=========================================="
echo ""
echo "Access your application at: http://localhost:8080"
echo ""
echo "Useful commands:"
echo "  - View logs: docker-compose logs -f"
echo "  - Stop: docker-compose down"
echo "  - Restart: docker-compose restart"
echo "  - Shell access: docker-compose exec app bash"
echo ""
