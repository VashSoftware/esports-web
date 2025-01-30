FROM php:8.4-fpm AS deps

RUN apt-get update && \
    apt-get install -y zip unzip npm && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY composer.json composer.lock ./
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer install --no-scripts --no-progress --prefer-dist --optimize-autoloader

RUN npm install -g bun
COPY package*.json bun.lock ./
RUN bun install

COPY . .
RUN bun run build

FROM php:8.4-fpm AS build

RUN apt-get update && \
    apt-get install -y nginx supervisor libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql bcmath opcache && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app
# Copy built assets and dependencies from deps stage
COPY --from=deps /app /app

# Generate application key and set permissions
RUN php artisan key:generate
RUN chmod -R 755 /app
RUN chown -R www-data:www-data /app

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]