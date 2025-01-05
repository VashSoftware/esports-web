# --- stage 1: build / composer install
FROM php:8.3-fpm AS build

# Install required packages
RUN apt-get update \
    && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:2.6 /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy all application files
COPY . .

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Laravel optimization
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# --- stage 2: final image
FROM php:8.3-fpm

# Reinstall PHP extensions
RUN apt-get update \
    && apt-get install -y \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install \
    pdo_mysql \
    zip \
    gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy application from the build stage
COPY --from=build /var/www/html /var/www/html

# Ensure writable storage
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose FPM port
EXPOSE 9000

# Default command
CMD ["php-fpm"]
