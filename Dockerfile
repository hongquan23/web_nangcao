# Base image: PHP 8.3 + Apache
FROM php:8.3-apache

# Cài tiện ích & extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath intl

# Bật rewrite module cho Laravel (Apache)
RUN a2enmod rewrite

# Cài Composer từ image chính thức
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ mã nguồn Laravel vào container
COPY . .

# Cài dependency Laravel (nên kiểm tra composer.lock nếu có)
RUN composer install --no-dev --optimize-autoloader

# Tạo thư mục cache nếu chưa có & cấp quyền
RUN mkdir -p storage/framework/{cache,sessions,views} && \
    mkdir -p bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Expose cổng 80
EXPOSE 80

# Lệnh khởi động chính
CMD php artisan config:cache && php artisan migrate --force && apache2-foreground
