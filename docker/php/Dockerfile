FROM php:8.4-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www/html

# Add user to avoid permission issues
ARG WWWUSER
ARG WWWGROUP
RUN groupadd -g ${WWWGROUP} www && useradd -u ${WWWUSER} -g www -m www

USER www

CMD ["php-fpm"]
