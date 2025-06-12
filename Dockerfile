FROM php:8.2-apache

# 1. Cài system packages + PHP extension
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev gnupg2 \
    && docker-php-ext-install pdo pdo_mysql zip \
    && a2enmod rewrite

# 2. Cài Node.js 18 (hoặc LTS mới nhất)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 3. Làm việc trong thư mục Laravel
WORKDIR /var/www/html

# 4. Copy toàn bộ project
COPY . .

# 5. Cài Composer dependencies (nếu cần)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

# ✅ 6. Đặt mirror npm và build frontend (Vite)
RUN npm config set registry https://registry.npmmirror.com \
    && npm install \
    && npm run build

# 7. Sửa Apache document root
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 8. Cấp quyền Laravel
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# ✅ 9. Tạo .env từ biến môi trường nếu chưa có
RUN [ ! -f .env ] && printenv | grep -v "no_proxy" > .env || true \
    && php artisan config:cache \
    && php artisan key:generate || true

EXPOSE 80
CMD ["apache2-foreground"]
