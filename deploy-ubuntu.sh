#!/bin/bash

# =====================================================
# Snipe-IT Custom Asset Deployment Script for Ubuntu
# =====================================================

set -e

echo "=========================================="
echo "Starting Snipe-IT Deployment on Ubuntu"
echo "=========================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
APP_DIR="/var/www/snipe-it"
REPO_URL="https://github.com/sssini563/CustomAsset.git"
PHP_VERSION="8.3"

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Please run as root or use sudo${NC}"
    exit 1
fi

echo -e "${GREEN}[1/8] Updating system packages...${NC}"
apt update && apt upgrade -y

echo -e "${GREEN}[2/8] Installing required packages...${NC}"
apt install -y software-properties-common

# Add PHP repository
add-apt-repository ppa:ondrej/php -y
apt update

# Install dependencies
apt install -y \
    nginx \
    mysql-server \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-cli \
    php${PHP_VERSION}-common \
    php${PHP_VERSION}-mysql \
    php${PHP_VERSION}-zip \
    php${PHP_VERSION}-gd \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-ldap \
    php${PHP_VERSION}-redis \
    php${PHP_VERSION}-soap \
    git \
    curl \
    unzip \
    supervisor

echo -e "${GREEN}[3/8] Installing Composer...${NC}"
if [ ! -f /usr/local/bin/composer ]; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

echo -e "${GREEN}[4/8] Cloning repository...${NC}"
if [ -d "$APP_DIR" ]; then
    echo -e "${YELLOW}Directory exists, pulling latest changes...${NC}"
    cd $APP_DIR
    git pull origin main
else
    git clone $REPO_URL $APP_DIR
    cd $APP_DIR
fi

echo -e "${GREEN}[5/8] Installing PHP dependencies...${NC}"
composer install --no-dev --optimize-autoloader

echo -e "${GREEN}[6/8] Setting up environment...${NC}"
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
    echo -e "${YELLOW}Please configure your .env file with database credentials${NC}"
fi

echo -e "${GREEN}[7/8] Setting permissions...${NC}"
chown -R www-data:www-data $APP_DIR
chmod -R 755 $APP_DIR
chmod -R 775 $APP_DIR/storage
chmod -R 775 $APP_DIR/bootstrap/cache
chmod -R 775 $APP_DIR/public/uploads

echo -e "${GREEN}[8/8] Configuring Nginx...${NC}"
cat > /etc/nginx/sites-available/snipe-it <<'NGINX_CONF'
server {
    listen 80;
    server_name _;
    root /var/www/snipe-it/public;

    index index.php index.html index.htm;

    client_max_body_size 100M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    location ~* \.(jpg|jpeg|gif|png|css|js|ico|xml|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        access_log off;
        log_not_found off;
    }
}
NGINX_CONF

# Enable site
ln -sf /etc/nginx/sites-available/snipe-it /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test and restart Nginx
nginx -t
systemctl restart nginx
systemctl enable nginx

# Restart PHP-FPM
systemctl restart php${PHP_VERSION}-fpm
systemctl enable php${PHP_VERSION}-fpm

echo ""
echo -e "${GREEN}=========================================="
echo "Deployment Complete!"
echo "==========================================${NC}"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "1. Configure database in .env file:"
echo "   nano $APP_DIR/.env"
echo ""
echo "2. Run database migrations:"
echo "   cd $APP_DIR"
echo "   php artisan migrate"
echo "   php artisan db:seed"
echo ""
echo "3. Configure MySQL (if needed):"
echo "   mysql_secure_installation"
echo "   mysql -u root -p"
echo "   CREATE DATABASE snipeit;"
echo "   CREATE USER 'snipeit'@'localhost' IDENTIFIED BY 'your_password';"
echo "   GRANT ALL PRIVILEGES ON snipeit.* TO 'snipeit'@'localhost';"
echo "   FLUSH PRIVILEGES;"
echo ""
echo -e "${GREEN}Application URL: http://your-server-ip${NC}"
echo ""
