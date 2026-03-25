# Stage 1: PHP Dependencies
FROM composer:latest as vendor
WORKDIR /app
COPY composer.json composer.lock ./
# We install without scripts/autoloader first to optimize caching
RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs

# Stage 2: Node Dependencies & Build
FROM node:20-alpine as frontend
WORKDIR /app
# Copy all frontend-related files
COPY package.json package-lock.json vite.config.js tailwind.config.js* postcss.config.js* ./ 
COPY resources ./resources
COPY public ./public
RUN npm install && npm run build

# Stage 3: Final Production Image
FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    icu-dev \
    libjpeg-turbo-dev \
    freetype-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip intl bcmath gd

WORKDIR /var/www

# 1. Copy the entire project first
COPY . .

# 2. Copy vendor from Stage 1 (Note the /app/ paths match now)
COPY --from=vendor /app/vendor ./vendor

# 3. Copy compiled assets from Stage 2
COPY --from=frontend /app/public/build ./public/build

# 4. CRITICAL: Generate the optimized autoload files
COPY --from=vendor /usr/bin/composer /usr/bin/composer
RUN composer dump-autoload --optimize --no-dev

# 5. Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]