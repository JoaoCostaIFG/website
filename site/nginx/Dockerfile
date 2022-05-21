FROM alpine:3.14
LABEL Maintainer="Joao Costa <joaocosta.work@posteo.net>"
LABEL Description="The container for my website"

RUN apk --no-cache add nginx composer

# nginx conf
COPY ./etc/nginx /etc/nginx

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

CMD ["/bin/nginx", "-g", "daemon off;"]
