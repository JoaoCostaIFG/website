FROM dunglas/frankenphp AS php_base

RUN apt-get update && \
        apt-get install -y npm && \
        apt-get clean && \
        rm -rf /var/lib/apt/lists/*

RUN install-php-extensions \
        @composer \
        curl \
        exif \
        gd \
        pdo_sqlite \
        session \
        sqlite3 \
        zip \
        openssl \
        opcache \
        json \
        fileinfo \
        tokenizer \
        dom \
        sodium \
        sockets \
        pcntl

COPY opcache.ini $PHP_INI_DIR/opcache.ini

EXPOSE 8000

# site code
WORKDIR /app
COPY src .

# ----------------------------------------------------------------------------

FROM php_base AS php_prod

# install php packages with composer
RUN composer install --optimize-autoloader -n -o --no-dev
# install javascript packages with npm
RUN npm install -D

# cache
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan ziggy:generate
# build stuff
RUN npm run build

# link storage
RUN php artisan storage:link && \
    rm -rf storage/app && \
    ln -s /data/storage storage/app

# use production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

CMD ["php", "artisan", "octane:start"]

# ----------------------------------------------------------------------------

FROM php_base AS php_dev

# install php packages with composer
RUN composer install -n
# install javascript packages with npm
RUN npm install -D

RUN install-php-extensions xdebug

COPY dev_entrypoint.sh /dev_entrypoint.sh

# use development settings and run as root
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

CMD ["/bin/sh", "/dev_entrypoint.sh"]
