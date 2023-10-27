# Use an official PHP runtime as a parent image
FROM php:8.1-apache

# Copy php.ini file
COPY deploy/php.ini /usr/local/etc/php/

# Copy start script
COPY deploy/start /usr/local/bin/start

RUN chmod +x /usr/local/bin/start

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app

# Fix file permissions
RUN mkdir -p /app/storage /app/bootstrap/cache
RUN chown -R www-data:www-data /app
RUN chmod -R ug+rwx /app/storage /app/bootstrap

ENV APACHE_DOCUMENT_ROOT /app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

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
    npm \
    postgresql-client \
    libpq-dev

# Install PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set composer as superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Run Composer install
RUN composer install --no-interaction --no-scripts --no-progress --optimize-autoloader --no-dev

# Compile assets
RUN npm ci

# Expose port 80 and start Apache server
EXPOSE 80
ENTRYPOINT [ "/usr/local/bin/start" ]
