FROM ghcr.io/roadrunner-server/roadrunner AS roadrunner
FROM php:cli-alpine3.18 AS php_base
# https://hub.docker.com/_/php/

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
RUN apk --no-cache add npm

# install dependencies using https://github.com/mlocati/docker-php-extension-installer
RUN curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions @composer curl exif gd pdo_sqlite session sqlite3 zip openssl opcache json fileinfo tokenizer dom sodium sockets pcntl

COPY php/opcache.ini $PHP_INI_DIR/opcache.ini

EXPOSE 8000

# wiki code
COPY wiki /app/wiki
# site code
COPY src /app/main

# ----------------------------------------------------------------------------

FROM php_base AS php_prod

# install php packages with composer
RUN cd /app/main && composer install --optimize-autoloader -n -o --no-dev
# install javascript packages with npm
RUN cd /app/main && npm install -D
# cache
RUN cd /app/main && \
  php artisan config:cache && \
  php artisan route:cache && \
  php artisan view:cache && \
  php artisan ziggy:generate
# build stuff
RUN cd /app/main && npm run build

# link storage
RUN cd /app/main && \
  php artisan storage:link && \
  rm -rf storage/app && \
  ln -s /data/main/storage storage/app

# set links so the app can access the data
RUN ln -s /data/wiki/conf /app/wiki/conf && \
    ln -s /data/wiki/data /app/wiki/data && \
    ln -s /data/wiki/lib/plugins /app/wiki/lib/plugins && \
    ln -s /data/wiki/lib/tpl /app/wiki/lib/tpl

# use production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /app/main/
CMD ["php", "artisan", "octane:start", "-n", "--server=roadrunner", "--host=0.0.0.0", "--port=8000"]

# ----------------------------------------------------------------------------

FROM php_base AS php_dev

# install php packages with composer
RUN cd /app/main && composer install -n -o
# install javascript packages with npm
RUN cd /app/main && npm install -D

RUN install-php-extensions xdebug

COPY php/dev_entrypoint.sh /dev_entrypoint.sh

# use development settings and run as root
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

CMD ["sh", "/dev_entrypoint.sh"]
