FROM php:8.2-apache

# Cài các gói PHP cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Bật mod_rewrite cho Laravel routing
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy source vào container
COPY . .

# Thiết lập DocumentRoot về thư mục public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Cấu hình quyền cho storage và cache
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Cài composer nếu chưa có
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Copy .env nếu chưa có và tạo APP_KEY
RUN cp .env.example .env || true && php artisan key:generate || true

EXPOSE 80

CMD ["apache2-foreground"]
