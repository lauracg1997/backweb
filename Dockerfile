FROM php:8.3-cli-alpine

RUN apk add --no-cache postgresql-dev zip unzip git oniguruma-dev libxml2-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring xml

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["sh", "-c", "php artisan storage:link --no-interaction 2>/dev/null; php artisan migrate --force; php artisan serve --host=0.0.0.0 --port=8000"]
