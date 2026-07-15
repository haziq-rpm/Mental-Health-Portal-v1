# ---- Stage 1: Build frontend assets (Vite + Tailwind) ----
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm install
COPY resources ./resources
COPY vite.config.js ./
COPY public ./public
RUN npm run build

# ---- Stage 2: PHP application ----
FROM php:8.2-cli

# System packages + PHP extensions required by Laravel 12 + MySQL
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libonig-dev libxml2-dev libcurl4-openssl-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath xml zip curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application code (respects .dockerignore)
COPY . .

# Bring in the assets built in stage 1
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies (production only, no dev tools)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Ensure Laravel's writable directories exist with correct permissions
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache/data storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

# Cache config/routes/views using Railway's real env vars (available at
# container start, not build time), then serve on Railway's dynamic $PORT.
CMD php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && (php artisan storage:link || true) \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
