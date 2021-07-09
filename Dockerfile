FROM archlinux

# Install dependencies
RUN pacman -Syu --noconfirm neovim make nginx php7 php7-gd php7-sqlite php7-fpm composer sqlite

# Copy project code and install project dependencies
COPY ./App /usr/share/nginx/joaocosta.dev/main/App
COPY ./resources /usr/share/nginx/joaocosta.dev/main/resources
COPY ./composer.json /usr/share/nginx/joaocosta.dev/main/composer.json
COPY ./composer.lock /usr/share/nginx/joaocosta.dev/main/composer.lock
COPY ./favicon.ico /usr/share/nginx/joaocosta.dev/main/favicon.ico
COPY ./index.php /usr/share/nginx/joaocosta.dev/main/index.php
COPY ./robots.txt /usr/share/nginx/joaocosta.dev/main/robots.txt
RUN chown -R http:http /usr/share/nginx/joaocosta.dev

RUN mkdir -p /var/lib/site/cache
RUN mkdir -p /var/lib/site/database
RUN mkdir -p /var/lib/site/storage
RUN chown -R http:http /var/lib/site

RUN ln -s /var/lib/site/cache/ /usr/share/nginx/joaocosta.dev/main/cache
RUN ln -s /var/lib/site/database/ /usr/share/nginx/joaocosta.dev/main/database
RUN ln -s /var/lib/site/storage/ /usr/share/nginx/joaocosta.dev/main/storage

# Copy project configurations
ADD ./etc/php/* /etc/php7/

COPY ./etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./etc/nginx/joaocosta.dev /etc/nginx/sites-available/joaocosta.dev
COPY ./etc/nginx/wiki.joaocosta.dev /etc/nginx/sites-available/wiki.joaocosta.dev
RUN mkdir -p /etc/nginx/sites-enabled
RUN ln -s /etc/nginx/sites-available/joaocosta.dev /etc/nginx/sites-enabled/joaocosta.dev
RUN ln -s /etc/nginx/sites-available/wiki.joaocosta.dev /etc/nginx/sites-enabled/wiki.joaocosta.dev

RUN mkdir -p /etc/nginx/certs
COPY ./keys/server.crt /etc/nginx/certs/server.pem
COPY ./keys/server.key /etc/nginx/certs/server_key.pem

COPY docker_run.sh /docker_run.sh

# Start command
CMD sh /docker_run.sh

# Expose ports.
EXPOSE 80
EXPOSE 443
