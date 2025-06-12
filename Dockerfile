FROM php:8.2-apache

# 1. Cài các gói cần thiết
RUN apt-get update && apt-get install -y \
    zip unzip git libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && a2enmod rewrite

# 2. Làm việc tại /var/www/html
WORKDIR /var/www/html

# 3. Copy code Laravel đã build sẵn
COPY . .

# 4. Thiết lập Apache để trỏ vào public/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 5. Cấp quyền thư mục cần thiết
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# 6. Tạo .env và app key (chạy được nếu artisan có sẵn)
RUN cp .env.example .env || true \
    && php artisan key:generate || true

# 7. Expose port và chạy Apache
EXPOSE 80
CMD ["apache2-foreground"]
