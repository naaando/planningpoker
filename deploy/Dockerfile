# Use an official PHP runtime as a parent image
FROM php:8.1-apache

# Copy php.ini file
COPY deploy/php.ini /usr/local/etc/php/

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app

# Fix storage permissions
RUN chown -R www-data:www-data /app

ENV APACHE_DOCUMENT_ROOT /app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install any needed packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set composer as superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Run Composer install
RUN composer install --no-interaction --no-scripts --no-progress --optimize-autoloader --no-dev

# Compile assets
RUN npm ci && npm build

# Cache config
RUN php artisan config:cache

# Expose port 80 and start Apache server
EXPOSE 80
CMD ["apache2-foreground"]
