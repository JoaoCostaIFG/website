FROM caddy:2.9-builder AS build

RUN xcaddy build \
    --with github.com/caddy-dns/cloudflare \
    --with github.com/mholt/caddy-dynamicdns \
    --with go.akpain.net/caddy-tailscale-auth

FROM caddy:2.9

COPY --from=build /usr/bin/caddy /usr/bin/caddy

COPY validation_env.env /validation_env.env
COPY Caddyfile /etc/caddy/Caddyfile
RUN caddy validate --config /etc/caddy/Caddyfile --envfile /validation_env.env
