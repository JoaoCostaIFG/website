# CouchDB docker container for Obsidian LiveSync

[obsidian-livesync](https://github.com/vrtmrz/obsidian-livesync) is a cool project to sync your Obsidian vaults between devices, but it isn't the easiest thing to get running. This repository provides the docker container that I use to host a bunchof Obsidian vaults.

## Setup environment

You need to setup a user and password for your CouchDB instance. Copy the [couchdb.env.example](./couchdb.env.example) file to `.env` and set the information you want.

## Run container

Just build the image and pass your environment file when running it:

```bash
docker build . -t obsidian-couchdb
docker run --name obsidian-couchdb -p "5984:5984" --env-file .env obsidian-couchdb
```

Now you should probably reverse-proxy a domain to this container or something along these lines. _Or maybe use something like [tailscale serve](https://tailscale.com/kb/1242/tailscale-serve)_

## Generate the setup URI

When you have the container running, run the following command and follow the instructions on screen to get your URI:

```bash
docker exec -it obsidian-couchdb generate_setupuri
```

Don't forget to save the output URI and passphrase. **Treat them as the username and password of your obsidian vault**.

## Obsidian side of things

Now open your obsidian vault and follow the [instructions on obsidian-livesync wiki](https://github.com/vrtmrz/obsidian-livesync/blob/main/docs/setup_own_server.md#2-setup-self-hosted-livesync-to-obsidian) on setting up the extension: this is where you will use the URI/passphrase from the previous set. It also has some guides on setting up a reverse proxy for your domain.
