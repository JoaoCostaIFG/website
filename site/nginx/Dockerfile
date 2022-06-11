FROM alpine:3.14 AS nginx_builder

RUN apk --no-cache add composer

# wiki code
COPY wiki /app/wiki
# site code
COPY src /app/main
# install stuff with composer
RUN cd /app/main && composer install -n -o

# -----------------------------------------------------------------------------

FROM nginx:alpine AS nginx_base

# nginx conf
COPY nginx/nginx-conf /etc/nginx

COPY --from=nginx_builder --chown=nginx:nginx /app /app

EXPOSE 80 443

# -----------------------------------------------------------------------------

FROM nginx_base AS nginx_prod

RUN ln -s /data/wiki/conf /app/wiki/conf && \
    ln -s /data/wiki/data /app/wiki/data && \
    ln -s /data/wiki/lib/plugins /app/wiki/lib/plugins && \
    ln -s /data/wiki/lib/tpl /app/wiki/lib/tpl && \
    ln -s /data/main/database /app/main/database && \
    ln -s /data/main/storage /app/main/storage

# -----------------------------------------------------------------------------

FROM nginx_base AS nginx_dev

# run development as root
RUN sed -i 's/user nginx;/user root;/' "/etc/nginx/nginx.conf"
