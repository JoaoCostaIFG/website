FROM alpine:3.14

RUN mkdir -p /socket

RUN apk --no-cache add \
  php8 \
  php8-curl \
  php8-exif \
  php8-fpm \
  php8-gd \
  php8-pdo_sqlite \
  php8-session \
  php8-sqlite3 \
  php8-zip \
  php8-openssl \
  php8-opcache
 
COPY php/opcache.ini /etc/php8/conf.d/opcache.ini
COPY php/php-fpm.conf /etc/php8/php-fpm.conf
COPY php/php.ini /etc/php8/php.ini
COPY php/www.conf /etc/php8/php-fpm.d/www.conf

CMD ["php-fpm8", "-F", "-R"]
