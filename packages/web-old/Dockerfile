FROM php:8.4-cli AS deps

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

FROM php:8.4-cli AS runtime

RUN apt-get update && \
    apt-get install -y libpq-dev nodejs npm && \
    docker-php-ext-install pdo pdo_pgsql bcmath opcache pcntl && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY --from=deps /app /app

# Ensure storage directories exist and set permissions
RUN chown -R www-data:www-data /app/storage

EXPOSE 8080

RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan optimize

# Start the SSR server, Reverb, and the main application server
CMD php artisan inertia:start-ssr & php artisan reverb:start & php artisan serve --host=0.0.0.0 --port=8080