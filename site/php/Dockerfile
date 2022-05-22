FROM alpine:3.14

RUN mkdir -p /socket

RUN apk --no-cache add \
  php7 \
  php7-curl \
  php7-exif \
  php7-fpm \
  php7-gd \
  php7-pdo_sqlite \
  php7-session \
  php7-sqlite3 \
  php7-zip \
  php7-openssl \
  php7-opcache \
  php7-json
 
COPY php/opcache.ini /etc/php7/conf.d/opcache.ini
COPY php/php-fpm.conf /etc/php7/php-fpm.conf
COPY php/php.ini /etc/php7/php.ini
COPY php/www.conf /etc/php7/php-fpm.d/www.conf

CMD ["php-fpm7", "-F", "-R"]
