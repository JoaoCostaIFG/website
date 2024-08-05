FROM couchdb:latest

RUN apt-get update && \
        apt-get install -y unzip && \
        apt-get clean && \
        rm -rf /var/lib/apt/lists/* && \
        curl -fsSL https://deno.land/install.sh | sh && \
        mv /root/.deno/bin/deno /usr/bin/deno

COPY generate_setupuri.sh /usr/bin/generate_setupuri
COPY generate_setupuri.ts /generate_setupuri.ts
COPY local.ini /opt/couchdb/etc/local.ini
