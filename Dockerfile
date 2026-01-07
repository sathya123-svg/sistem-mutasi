############################
# STAGE 1: Build Vite
############################
FROM node:20-alpine AS nodebuild

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build


############################
# STAGE 2: Laravel + Apache
############################
FROM php:8.3-apache

RUN a2enmod rewrite

# System deps
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip unzip git curl

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install gd pdo pdo_mysql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Copy hasil build Vite
COPY --from=nodebuild /app/public/build public/build

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Apache ke public/
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
