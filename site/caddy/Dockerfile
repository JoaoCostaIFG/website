FROM caddy:2.9-builder AS build

RUN xcaddy build \
    --with github.com/caddy-dns/cloudflare \
    --with go.akpain.net/caddy-tailscale-auth

FROM caddy:2.9

COPY --from=build /usr/bin/caddy /usr/bin/caddy

COPY Caddyfile /etc/caddy/Caddyfile
