FROM php:fpm-alpine3.16 AS php_base
# https://hub.docker.com/_/php/

RUN apk --no-cache add npm

WORKDIR /

# create user with same ID as the one used by nginx
RUN addgroup -g 101 -S php-fpm \
    && adduser -S -D -H -u 101 -h /var/cache/php-fpm -s /sbin/nologin -G php-fpm -g php-fpm php-fpm
    
# install dependencies using https://github.com/mlocati/docker-php-extension-installer
RUN curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions @composer \
      curl exif gd pdo_sqlite session sqlite3 zip openssl opcache json fileinfo tokenizer dom

COPY php/opcache.ini $PHP_INI_DIR/opcache.ini
COPY php/www.conf /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000

# ----------------------------------------------------------------------------

FROM php_base AS php_builder

# wiki code
COPY wiki /app/wiki
# site code
COPY src /app/main
# install php packages with composer
RUN cd /app/main && composer install -n -o
# install javascript packages with npm
RUN cd /app/main && npm install -D

# ----------------------------------------------------------------------------

FROM php_builder AS php_prod

# use production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# ----------------------------------------------------------------------------

FROM php_builder AS php_dev

RUN install-php-extensions xdebug

# use development settings and run as root
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/php-fpm/root/g' "/usr/local/etc/php-fpm.d/www.conf"

CMD ["php-fpm", "-R"]
