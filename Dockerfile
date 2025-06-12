FROM php:8.2-apache

# Cài các gói hệ thống và PHP extension
RUN apt-get update && apt-get install -y \
    zip unzip git libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && a2enmod rewrite

# Làm việc trong thư mục Laravel
WORKDIR /var/www/html

# Copy toàn bộ mã nguồn (bao gồm cả vendor/)
COPY . .

# Sửa DocumentRoot về public/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Cấp quyền cho Laravel
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Copy .env nếu chưa có, generate key
RUN cp .env.example .env || true \
    && php artisan key:generate || true

EXPOSE 80
CMD ["apache2-foreground"]
