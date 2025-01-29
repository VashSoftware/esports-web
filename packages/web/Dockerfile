FROM php:8.4-fpm AS build

RUN apt update && apt install -y zip unzip npm

WORKDIR /app
COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
RUN composer install --no-scripts --no-progress --prefer-dist --optimize-autoloader
RUN npm install -g bun
RUN bun install && bun run build

RUN apt install -y nginx supervisor \
    && docker-php-ext-install pdo pdo_mysql bcmath opcache \
    && chown -R www-data:www-data /app

COPY .env.example .env
RUN php artisan key:generate
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
