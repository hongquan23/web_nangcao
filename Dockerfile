FROM php:8.2-apacheAdd commentMore actions

# Cài các gói PHP cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
# 1. Cài Node.js + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y \
    nodejs \
    zip unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Bật mod_rewrite cho Laravel routing
# 2. Bật mod_rewrite
RUN a2enmod rewrite

# Set working directory
# 3. Set working directory
WORKDIR /var/www/html

# Copy source vào container
# 4. Copy source vào container
COPY . .

# Thiết lập DocumentRoot về thư mục public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
# 5. Build assets bằng Vite
RUN npm install && npm run build

# Cấu hình quyền cho storage và cache
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache
# 6. Thiết lập DocumentRoot về public/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Cài composer nếu chưa có
# 7. Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Copy .env nếu chưa có và tạo APP_KEY
# 8. Cấp quyền cho storage, cache
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# 9. Tạo .env và key nếu cần
RUN cp .env.example .env || true && php artisan key:generate || true

EXPOSE 80

CMD ["apache2-foreground"]