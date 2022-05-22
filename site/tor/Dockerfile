FROM alpine:3.14

RUN apk --no-cache add tor

COPY ./torrc /etc/tor/torrc

CMD ["tor", "-f", "/etc/tor/torrc"]
