FROM php:7.4-fpm-alpine AS php
# https://hub.docker.com/_/php/

WORKDIR /

# create user with same ID as the one used by nginx
RUN addgroup -g 101 -S php-fpm \
    && adduser -S -D -H -u 101 -h /var/cache/php-fpm -s /sbin/nologin -G php-fpm -g php-fpm php-fpm
    
# install dependencies using https://github.com/mlocati/docker-php-extension-installer
RUN curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions curl exif gd pdo_sqlite session sqlite3 zip openssl opcache json

COPY php/opcache.ini $PHP_INI_DIR/opcache.ini
COPY php/www.conf /usr/local/etc/php-fpm.d/www.conf

ARG DEV
# choose default configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

EXPOSE 9000

# ----------------------------------------------------------------------------

FROM php AS php_test

# use development settings and run as root
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/php-fpm/root/g' "/usr/local/etc/php-fpm.d/www.conf"

CMD ["php-fpm", "-R"]
