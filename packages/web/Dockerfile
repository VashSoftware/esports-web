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

# Copy full code and build in this stage
COPY . .
RUN bun run build

FROM php:8.4-fpm AS build

RUN apt-get update && \
    apt-get install -y nginx supervisor && \
    docker-php-ext-install pdo pdo_mysql bcmath opcache && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY --from=deps /app/vendor /app/vendor
COPY --from=deps /app/node_modules /app/node_modules
COPY --from=deps /app/public /app/public

COPY . .

RUN chown -R www-data:www-data /app

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
