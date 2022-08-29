FROM nginx:alpine AS nginx_base
# https://hub.docker.com/_/nginx

# nginx conf
COPY nginx/nginx-conf /etc/nginx

EXPOSE 80 443

# -----------------------------------------------------------------------------

FROM nginx_base AS nginx_prod

# -----------------------------------------------------------------------------

FROM nginx_base AS nginx_dev

# run development as root
RUN sed -i 's/user nginx;/user root;/' "/etc/nginx/nginx.conf"
