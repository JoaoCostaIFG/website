FROM dunglas/frankenphp:1.2.5-builder-php8.3-alpine AS php_base

RUN \
apk add --no-cache npm py3-pip && \
\
install-php-extensions \
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
        pcntl && \
\
python3 -m venv /venv && source /venv/bin/activate && \
pip install "git+https://github.com/JoaoCostaIFG/osig-cli.git"

COPY opcache.ini $PHP_INI_DIR/opcache.ini

EXPOSE 8000 9000

WORKDIR /app

# ----------------------------------------------------------------------------

FROM php_base AS php_prod

# site code
COPY . .

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

CMD ["/bin/sh", "/prod_entrypoint.sh"]

# ----------------------------------------------------------------------------

FROM php_base AS php_dev

COPY . .

COPY dev_entrypoint.sh /dev_entrypoint.sh

# use development settings and run as root
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

CMD ["/bin/sh", "/dev_entrypoint.sh"]
