# Use the PHP with Apache image
FROM php:8.1-apache

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    mariadb-client

# Install PHP extensions
RUN docker-php-ext-install \
    intl \
    mbstring \
    pdo_mysql

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the project files to the container
COPY . .

# Install application dependencies including require-dev packages
RUN composer install --no-interaction --optimize-autoloader

# Enable Apache rewrite module
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start the Apache web server
CMD ["apache2-foreground"]
