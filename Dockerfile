# Stage 1: Composer
FROM composer:latest as vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Stage 2: Frontend
FROM node:20-alpine as frontend
WORKDIR /app
COPY . .
RUN npm install && npm run build

# Stage 3: Final Image
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    zip unzip git \
    oniguruma-dev icu-dev \
    libjpeg-turbo-dev freetype-dev

RUN docker-php-ext-install pdo_mysql mbstring zip intl bcmath gd

WORKDIR /var/www

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["php-fpm"]