FROM alpine:3.14
LABEL Maintainer="Joao Costa <joaocosta.work@posteo.net>"
LABEL Description="The container for my website"

# dependencies: nginx, php, composer, sqlite
RUN apk --no-cache add \
  nginx \
  php7 \
  php7-curl \
  php7-exif \
  php7-fpm \
  php7-gd \
  php7-pdo_sqlite \
  php7-session \
  php7-sqlite3 \
  php7-zip \
  composer \
  supervisor

# php conf
RUN mkdir /run/php-fpm7 && touch /run/php-fpm7/php-fpm.sock
COPY ./etc/php /etc/php7

# nginx conf
COPY ./etc/nginx /etc/nginx
# enable sites
RUN \
  mkdir -p /etc/nginx/sites-enabled && \
  ln -s /etc/nginx/sites-available/joaocosta.dev /etc/nginx/sites-enabled/joaocosta.dev && \
  ln -s /etc/nginx/sites-available/wiki.joaocosta.dev /etc/nginx/sites-enabled/wiki.joaocosta.dev

# Configure supervisord
COPY ./etc/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# nginx/php user
RUN adduser -D -g 'http' http

# copy main site code
COPY ./src /usr/share/joaocosta.dev/main
# composer
RUN cd /usr/share/joaocosta.dev/main && composer install -n -o
# set mount points for site
RUN \
  mkdir -p /var/lib/joaocosta.dev/main/cache && \
  ln -s /var/lib/joaocosta.dev/main/cache /usr/share/joaocosta.dev/main/cache && \
  mkdir -p /var/lib/joaocosta.dev/main/database && \
  ln -s /var/lib/joaocosta.dev/main/database /usr/share/joaocosta.dev/main/database && \
  mkdir -p /var/lib/joaocosta.dev/main/storage && \
  ln -s /var/lib/joaocosta.dev/main/storage /usr/share/joaocosta.dev/main/storage && \
  mkdir -p /var/lib/joaocosta.dev/certs

# set ownerships and switch to use a non-root user from here on
RUN chown -R http:http /var/lib/joaocosta.dev /run /var/lib/nginx /var/log/nginx /var/log/php7
USER http

EXPOSE 80 443
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
