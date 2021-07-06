FROM archlinux

# Install dependencies
RUN pacman -Syu --noconfirm neovim make nginx php7 php7-gd php7-sqlite php7-fpm composer sqlite

# Copy project code and install project dependencies
COPY . /usr/share/nginx/joaocosta.dev/main
RUN chown -R http:http /usr/share/nginx/joaocosta.dev/main

# Copy project configurations
ADD ./etc/php/* /etc/php7/

COPY ./etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./etc/nginx/joaocosta.dev /etc/nginx/sites-available/joaocosta.dev
RUN mkdir -p /etc/nginx/sites-enabled
RUN ln -s /etc/nginx/sites-available/joaocosta.dev /etc/nginx/sites-enabled/joaocosta.dev

RUN mkdir -p /etc/nginx/certs
COPY ./keys/server.crt /etc/nginx/certs/server.pem
COPY ./keys/server.key /etc/nginx/certs/server_key.pem

COPY docker_run.sh /docker_run.sh

# Start command
CMD sh /docker_run.sh

# Expose ports.
EXPOSE 80
EXPOSE 443
