FROM nginx:alpine AS nginx_base
# https://hub.docker.com/_/nginx

# nginx conf
COPY nginx/nginx-conf /etc/nginx

EXPOSE 80 443

# -----------------------------------------------------------------------------

FROM nginx_base AS nginx_prod

# set links so the app can access the data
RUN ln -s /data/wiki/conf /app/wiki/conf && \
    ln -s /data/wiki/data /app/wiki/data && \
    ln -s /data/wiki/lib/plugins /app/wiki/lib/plugins && \
    ln -s /data/wiki/lib/tpl /app/wiki/lib/tpl
#    ln -s /data/main/storage /app/main/storage

# -----------------------------------------------------------------------------

FROM nginx_base AS nginx_dev

# run development as root
RUN sed -i 's/user nginx;/user root;/' "/etc/nginx/nginx.conf"
