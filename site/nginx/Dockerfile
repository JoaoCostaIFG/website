FROM alpine:3.14
LABEL Maintainer="Joao Costa <joaocosta.work@posteo.net>"
LABEL Description="The container for my website"

RUN apk --no-cache add nginx composer

# nginx conf
COPY nginx-conf /etc/nginx

# site code
COPY src /main
# wiki code
COPY wiki /wiki

# composer
RUN cd /main && composer install -n -o

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
