FROM php:7.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    curl \
    libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd tokenizer xml zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# 1. Remove broken lock file
# 2. Disable security audit (since Laravel 5.8 has old packages with known advisories)
# 3. Perform fresh installation
RUN rm -f composer.lock && \
    composer config audit.block-insecure false && \
    composer update --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port (Railway will provide $PORT)
EXPOSE $PORT

# Start Laravel built-in server
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
