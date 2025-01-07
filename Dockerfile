# Gunakan image base
FROM php:8.2-fpm

# Tambahkan script untuk menghindari interaksi dengan APT
ENV DEBIAN_FRONTEND noninteractive

# Update package list dan install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www \
    && chmod -R 755 storage bootstrap/cache

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# Copy and set permissions for entrypoint
COPY ./docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port
EXPOSE 9000

# Set entrypoint
ENTRYPOINT ["/entrypoint.sh"]

# Start PHP-FPM
CMD ["php-fpm"]
