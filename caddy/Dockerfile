FROM caddy:2.10.0-builder AS build

RUN xcaddy build \
  --with github.com/caddy-dns/cloudflare \
  --with github.com/mholt/caddy-dynamicdns \
  --with github.com/tailscale/caddy-tailscale

FROM caddy:2.9.1

COPY --from=build /usr/bin/caddy /usr/bin/caddy

COPY validation_env.env /validation_env.env
COPY Caddyfile /etc/caddy/Caddyfile
RUN caddy fmt /etc/caddy/Caddyfile --overwrite && \
  caddy validate --config /etc/caddy/Caddyfile --envfile /validation_env.env
