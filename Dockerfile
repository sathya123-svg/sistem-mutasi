FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    nodejs \
    npm \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip gd

# Set working directory
WORKDIR /app

# Copy project files (INI PENTING HARUS SEBELUM npm build)
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 🔥 INSTALL & BUILD VITE
RUN npm install
RUN npm run build

# (optional tapi aman)
RUN php artisan storage:link || true

# Expose port
EXPOSE 8000

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
