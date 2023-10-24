# Use an official PHP runtime as a parent image
FROM php:8.1-fpm

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY .. /app

# Install any needed packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run Composer install
RUN composer install --no-interaction --no-scripts --no-progress

# Compile assets
# RUN npm install && npm build

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
