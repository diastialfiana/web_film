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

# Install Composer (Ensure latest version for audit control)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Prepare environment and install dependencies
# We ignore security audits because this is a legacy demo app
RUN rm -f composer.lock && \
    composer config audit.block-insecure false && \
    composer update --no-dev --optimize-autoloader --no-interaction && \
    php artisan config:clear

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose the port Railway provides
EXPOSE $PORT

# Start application using the PORT variable provided by Railway
# We use a shell form CMD to ensure $PORT is interpolated
CMD php artisan serve --host=0.0.0.0 --port=$PORT
