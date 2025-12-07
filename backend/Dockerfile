FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock* ./

RUN composer install \
    --no-interaction \
    --no-ansi \
    --no-scripts \
    --no-progress


COPY . .


RUN if [ ! -f .env ]; then cp .env.example .env; fi


RUN composer install
RUN php artisan key:generate
RUN php artisan migrate --seed

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
