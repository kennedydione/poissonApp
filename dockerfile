FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip \
    && docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install

# Prepare writable storage (SQLite + cache)
RUN mkdir -p /app/storage /app/bootstrap/cache \
    && touch /app/storage/database.sqlite \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Generate APP_KEY if missing (won't override if already set)
RUN cp -n .env.example .env || true
RUN php artisan key:generate --force || true

# Run migrations then start the app
CMD php artisan migrate --force --no-interaction && php artisan serve --host=0.0.0.0 --port=10000
