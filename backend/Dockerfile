FROM php:8.4-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock* ./

# Install dependencies
RUN composer install \
    --no-interaction \
    --no-ansi \
    --no-scripts \
    --no-progress

# Copy the rest of the application
COPY . .

# Copy env example if .env does not exist
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Generate app key
RUN php artisan key:generate

# Expose port Laravel will serve on
EXPOSE 8000

# Default command: run the dev server
CMD php artisan serve --host=0.0.0.0 --port=8000
