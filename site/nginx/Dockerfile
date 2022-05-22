FROM alpine:3.14 as builder

RUN apk --no-cache add composer
# wiki code
COPY wiki /app/wiki
# site code
COPY src /app/main
RUN ln -s /data/main/database /app/main/database && \
    ln -s /data/main/storage /app/main/storage
# composer
RUN cd /app/main && composer install -n -o

FROM alpine:3.14

RUN apk --no-cache add nginx
# nginx conf
COPY nginx/nginx-conf /etc/nginx

COPY --from=builder /app /app

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
