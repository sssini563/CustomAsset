FROM snipe/snipe-it:latest

# Bake project files into the image (override base app contents)
USER root

# Apply custom PHP configuration to both Apache and CLI across versions
COPY docker/php-custom.ini /usr/local/etc/php/conf.d/zzz-custom.ini
RUN set -eux; \
      for V in 8.4 8.3 8.2 8.1; do \
            for SAPI in apache2 cli; do \
                  if [ -d "/etc/php/$V/$SAPI/conf.d" ]; then \
                        cp /usr/local/etc/php/conf.d/zzz-custom.ini "/etc/php/$V/$SAPI/conf.d/zzz-custom.ini"; \
                  fi; \
            done; \
      done

# Copy application source first (respects .dockerignore), then run composer install
WORKDIR /var/www/html
COPY . /var/www/html

# Ensure we don't bake host .env into the image
RUN rm -f /var/www/html/.env

# Install Composer without pulling composer:2 image (avoids Docker Hub auth issues)
RUN set -eux; \
      php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
      php composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
      rm composer-setup.php

# Install project dependencies (skip scripts to avoid running artisan during build)
RUN set -eux; \
      export COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1; \
      php -d memory_limit=-1 /usr/local/bin/composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts; \
      rm -rf vendor/*/*/.git; \
      chown -R docker:staff /var/www/html; \
      rm -f /var/www/html/bootstrap/cache/*.php