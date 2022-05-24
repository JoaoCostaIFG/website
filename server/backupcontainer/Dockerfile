FROM ubuntu

RUN apt-get update && apt-get install -y sqlite3 rsync

COPY ./entry.sh /entry.sh

CMD ["/bin/sh", "/entry.sh"]
