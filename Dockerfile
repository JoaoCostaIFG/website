FROM alpine:3.14
LABEL Maintainer="Joao Costa <joaocosta.work@posteo.net>"
LABEL Description="The container for my website"

# dependencies: nginx, php, composer, sqlite
RUN apk --no-cache add \
  curl \
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
  sqlite

# php conf
RUN mkdir /run/php-fpm7
RUN touch /run/php-fpm7/php-fpm.sock
COPY ./etc/php /etc/php7

# nginx conf
COPY ./etc/nginx /etc/nginx
# enable sites
RUN mkdir -p /etc/nginx/sites-enabled
RUN \
  ln -s /etc/nginx/sites-available/joaocosta.dev /etc/nginx/sites-enabled/joaocosta.dev && \
  ln -s /etc/nginx/sites-available/wiki.joaocosta.dev /etc/nginx/sites-enabled/wiki.joaocosta.dev
# ssl certificates
RUN mkdir -p /etc/nginx/certs
COPY ./keys/server.crt /etc/nginx/certs/server.pem
COPY ./keys/server.key /etc/nginx/certs/server_key.pem

# nginx/php user
RUN adduser -D -g 'http' http

# copy main site code
COPY ./App /usr/share/joaocosta.dev/main/App
COPY ./resources /usr/share/joaocosta.dev/main/resources
COPY ./composer.lock ./composer.json ./favicon.ico ./index.php ./robots.txt /usr/share/joaocosta.dev/main/
# composer
RUN cd /usr/share/joaocosta.dev/main && composer install -n -o
# set mount points for site
RUN \
  mkdir -p /var/lib/joaocosta.dev/main/cache && \
  ln -s /var/lib/joaocosta.dev/main/cache /usr/share/joaocosta.dev/main/cache && \
  mkdir -p /var/lib/joaocosta.dev/main/database && \
  ln -s /var/lib/joaocosta.dev/main/database /usr/share/joaocosta.dev/main/database && \
  mkdir -p /var/lib/joaocosta.dev/main/storage && \
  ln -s /var/lib/joaocosta.dev/main/storage /usr/share/joaocosta.dev/main/storage
COPY ./database /var/lib/joaocosta.dev/main/database
# init database
RUN sqlite3 /var/lib/joaocosta.dev/main/database/db.db < /var/lib/joaocosta.dev/main/database/db.sql
# set ownership of directory
RUN chown -R http:http /var/lib/joaocosta.dev

# switch to use a non-root user from here on
# USER nobody

EXPOSE 80
EXPOSE 443

# script to be run
COPY docker_run.sh /docker_run.sh
CMD sh /docker_run.sh
