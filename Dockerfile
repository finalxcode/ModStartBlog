FROM php:7.0-fpm-alpine

RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "php_admin_value[error_log] = /var/log/php/php-fpm.log" >> /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g 1000 ubuntu && \
adduser -u 1000 -G ubuntu -h /home/ubuntu -D ubuntu

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    ttf-dejavu \
    ttf-freefont \
    freetype-dev \
    libjpeg-turbo-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get Composer 1.10 (compatible with PHP 7.0)
COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Set git security directory
RUN git config --global --add safe.directory /var/www/html

# Set memory limit for Composer
ENV COMPOSER_MEMORY_LIMIT=-1

# Install project dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Set correct permissions
RUN mkdir -p /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/logs \
    /var/www/html/storage/app/public \
    /var/www/html/bootstrap/cache \
    /var/www/html/public/vendor/captcha/fonts

RUN chown -R ubuntu:ubuntu /var/www/html && \
    chmod -R 775 /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    /var/www/html/public/vendor/captcha \
    /var/www/html/vendor && \
    chmod -R 775 /var/www/html/storage/framework \
    /var/www/html/storage/logs \
    /var/www/html/storage/app