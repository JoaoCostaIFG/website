FROM alpine:3.14 AS nginx_builder

RUN apk --no-cache add composer npm

# wiki code
COPY wiki /app/wiki
# site code
COPY src /app/main
# install php packages with composer
RUN cd /app/main && composer install -n -o
# install javascript packages with npm
RUN cd /app/main && npm install -D
# build css with tailwindcss
RUN cd /app/main && npx tailwindcss -i ./resources/css/style_input.css -o ./resources/css/style.css --minify
# build css with tailwindcss
RUN cd /app/main && npm run build
RUN ls -la /app/main/dist

# -----------------------------------------------------------------------------

FROM nginx:alpine AS nginx_base
# https://hub.docker.com/_/nginx

# nginx conf
COPY nginx/nginx-conf /etc/nginx

COPY --from=nginx_builder --chown=nginx:nginx /app /app

EXPOSE 80 443

# -----------------------------------------------------------------------------

FROM nginx_base AS nginx_prod

# set links so the app can access the data
RUN ln -s /data/wiki/conf /app/wiki/conf && \
    ln -s /data/wiki/data /app/wiki/data && \
    ln -s /data/wiki/lib/plugins /app/wiki/lib/plugins && \
    ln -s /data/wiki/lib/tpl /app/wiki/lib/tpl && \
    ln -s /data/main/database /app/main/database && \
    ln -s /data/main/storage /app/main/storage

# -----------------------------------------------------------------------------

FROM nginx_base AS nginx_dev

RUN apk --no-cache add npm

COPY nginx/dev_cmd.sh /dev_cmd.sh

# run development as root
RUN sed -i 's/user nginx;/user root;/' "/etc/nginx/nginx.conf"

CMD ["sh", "/dev_cmd.sh"]
