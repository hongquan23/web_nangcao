FROM php:8.2-apache

# 1. Cài Node.js, npm, và các gói cần thiết
RUN apt-get update && apt-get install -y \
    curl zip unzip git libzip-dev gnupg ca-certificates \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql zip

# 2. Bật mod_rewrite
RUN a2enmod rewrite

# 3. Thiết lập thư mục làm việc
WORKDIR /var/www/html

# 4. Copy code Laravel vào container
COPY . .

# 5. Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# 6. Cài JS dependencies và build assets
RUN npm install && npm run build

# 7. Sửa DocumentRoot cho Apache
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 8. Cấp quyền cho Laravel
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# 9. Tạo .env nếu cần và generate APP_KEY
RUN cp .env.example .env || true \
    && php artisan key:generate || true

# 10. Expose port và start Apache
EXPOSE 80
CMD ["apache2-foreground"]
