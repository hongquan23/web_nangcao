FROM php:8.2-apache

# Cài các extension cần thiết
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy code vào container
COPY . /var/www/html

# Set quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Bật rewrite module
RUN a2enmod rewrite

# Tạo thư mục cache cho Laravel
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Đặt thư mục làm việc mặc định
WORKDIR /var/www/html
