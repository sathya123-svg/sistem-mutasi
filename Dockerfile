FROM node:20-bullseye AS nodebuild
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
COPY --from=nodebuild /app/public/build public/build

RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate || true
RUN php artisan storage:link || true

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD php -S 0.0.0.0:8080 -t public
