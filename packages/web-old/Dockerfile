FROM php:8.3-fpm

WORKDIR /var/www

COPY . .

RUN apt-get update && \
    apt-get install -y libpq-dev libpng-dev libonig-dev libxml2-dev nodejs npm zip unzip git supervisor nginx libjpeg-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_pgsql bcmath opcache pcntl gd exif && \
    rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN npm install -g bun
COPY package*.json bun.lock* ./
RUN bun install

RUN bun run build

COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear
# RUN php artisan optimize

RUN chown -R www-data:www-data /var/www

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-n"]