FROM node:18 as node_builder

WORKDIR /app
# Copy toàn bộ file liên quan đến build assets của Vite
COPY package*.json ./
RUN npm install
COPY . .
# Build assets (lệnh có thể thay đổi tùy project)
RUN npm run build

FROM php:8.2-apache

# Cài các gói PHP cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

RUN a2enmod rewrite

WORKDIR /var/www/html

# Copy source code từ container trước
COPY . .

# Copy kết quả build assets từ container node_builder sang thư mục public
COPY --from=node_builder /app/public/build public/build

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

RUN cp .env.example .env || true && php artisan key:generate || true

EXPOSE 80

CMD ["apache2-foreground"]
