# Use official PHP image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git libxml2-dev libzip-dev libpng-dev libjpeg-dev libonig-dev \
    sqlite3 libsqlite3-dev libpq-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . /var/www
COPY --chown=www-data:www-data . /var/www

# Set permissions
RUN chmod -R 755 /var/www

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Run migrations during build (temporary, remove after successful deploy)



# Expose port 8000
EXPOSE 8000

# Start Laravel's built-in server
CMD php artisan db:seed --force