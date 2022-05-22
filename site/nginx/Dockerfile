FROM alpine:3.14
LABEL Maintainer="Joao Costa <joaocosta.work@posteo.net>"
LABEL Description="The container for my website"

RUN apk --no-cache add nginx composer

# nginx conf
COPY nginx/nginx-conf /etc/nginx

# site code
COPY src /app/main
# wiki code
COPY wiki /app/wiki

# composer
RUN cd /app/main && composer install -n -o

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
