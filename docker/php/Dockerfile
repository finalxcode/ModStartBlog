FROM php:8.1-fpm-bullseye

# 安装系统依赖
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev

# 安装 PHP 扩展
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath

# 验证 GD 和 FreeType 是否正确安装
RUN php -r 'var_dump(gd_info());'

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 设置工作目录
WORKDIR /var/www/html

# 复制项目文件
COPY . /var/www/html

# 设置权限
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html/storage -type d -exec chmod 775 {} \; \
    && find /var/www/html/storage -type f -exec chmod 664 {} \; \
    && chmod -R ug+rwx /var/www/html/storage \
    && chmod -R ug+rwx /var/www/html/bootstrap/cache

# 创建一个启动脚本
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]

# 设置 PHP 配置
RUN echo "upload_max_filesize=100M" >> /usr/local/etc/php/conf.d/docker-php-ext-upload.ini \
    && echo "post_max_size=100M" >> /usr/local/etc/php/conf.d/docker-php-ext-upload.ini \
    && echo "memory_limit=512M" >> /usr/local/etc/php/conf.d/docker-php-ext-upload.ini \
    && echo "max_execution_time=600" >> /usr/local/etc/php/conf.d/docker-php-ext-upload.ini \
    && echo "max_input_time=600" >> /usr/local/etc/php/conf.d/docker-php-ext-upload.ini

# 设置时区
RUN echo "date.timezone=Asia/Shanghai" >> /usr/local/etc/php/conf.d/docker-php-ext-timezone.ini

# 设置用户
USER www-data 