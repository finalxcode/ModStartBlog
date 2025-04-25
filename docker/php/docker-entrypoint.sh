#!/bin/bash
set -e

# 确保storage和bootstrap/cache目录存在
mkdir -p /var/www/html/storage
mkdir -p /var/www/html/bootstrap/cache

# 设置目录权限
chown -R www-data:www-data /var/www/html
find /var/www/html/storage -type d -exec chmod 775 {} \;
find /var/www/html/storage -type f -exec chmod 664 {} \;
chmod -R ug+rwx /var/www/html/storage
chmod -R ug+rwx /var/www/html/bootstrap/cache

# 执行传入的命令（通常是php-fpm）
exec "$@" 