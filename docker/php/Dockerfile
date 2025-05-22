FROM --platform=linux/amd64 php:8.4-fpm as base

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    bcmath \
    gd \
    zip \
    && apt-get purge -y --auto-remove \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# Add user to avoid permission issues
ARG WWWUSER
ARG WWWGROUP
RUN groupadd -g ${WWWGROUP} www && useradd -u ${WWWUSER} -g www -m www

USER www

CMD ["php-fpm"]
