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
  s6-overlay \
  tor

# nginx/php user
RUN adduser -D -g 'http' http

# php conf
COPY ./etc/php /etc/php7
RUN mkdir -m 0770 /run/php-fpm7 && chown -R http:http /run/php-fpm7

# nginx conf
COPY ./etc/nginx /etc/nginx
RUN chown -R http:http /var/lib/nginx
# enable sites
RUN \
  mkdir -p /etc/nginx/sites-enabled && \
  ln -s /etc/nginx/sites-available/joaocosta.dev /etc/nginx/sites-enabled/joaocosta.dev && \
  ln -s /etc/nginx/sites-available/wiki.joaocosta.dev /etc/nginx/sites-enabled/wiki.joaocosta.dev

# tor conf
COPY ./etc/torrc /etc/tor/torrc

# s6-overlay service
COPY ./etc/s6-overlay/services.d /etc/services.d
COPY ./etc/s6-overlay/fix-attrs.d /etc/fix-attrs.d

# site code
COPY ./src /usr/share/joaocosta.dev/main
# composer
RUN cd /usr/share/joaocosta.dev/main && composer install -n -o
# set mount points for main site
RUN \
  mkdir -p /var/lib/joaocosta.dev/main/cache && \
  ln -s /var/lib/joaocosta.dev/main/cache /usr/share/joaocosta.dev/main/cache && \
  mkdir -p /var/lib/joaocosta.dev/main/database && \
  ln -s /var/lib/joaocosta.dev/main/database /usr/share/joaocosta.dev/main/database && \
  mkdir -p /var/lib/joaocosta.dev/main/storage && \
  ln -s /var/lib/joaocosta.dev/main/storage /usr/share/joaocosta.dev/main/storage && \
  mkdir -p /var/lib/joaocosta.dev/certs

# wiki code
COPY ./wiki /usr/share/joaocosta.dev/wiki
# set mount points for wiki site
RUN \
  mkdir -p /var/lib/joaocosta.dev/wiki/conf && \
  ln -s /var/lib/joaocosta.dev/wiki/conf /usr/share/joaocosta.dev/wiki/conf && \
  mkdir -p /var/lib/joaocosta.dev/wiki/data && \
  ln -s /var/lib/joaocosta.dev/wiki/data /usr/share/joaocosta.dev/wiki/data && \
  mkdir -p /var/lib/joaocosta.dev/wiki/lib/plugins && \
  ln -s /var/lib/joaocosta.dev/wiki/lib/plugins /usr/share/joaocosta.dev/wiki/lib/plugins && \
  mkdir -p /var/lib/joaocosta.dev/wiki/lib/tpl && \
  ln -s /var/lib/joaocosta.dev/wiki/lib/tpl /usr/share/joaocosta.dev/wiki/lib/tpl

EXPOSE 80 443

ENTRYPOINT ["/init"]
