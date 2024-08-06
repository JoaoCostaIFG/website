# My Synapse server container

Why this container:

- It includes [synapse-s3-storage-provider](https://github.com/matrix-org/synapse-s3-storage-provider)
- Includes a wrapper script for `s3_media_upload`:
  - The main reason for this script is so I can automate tasks by reading the homeserver's config file (e.g. get the bucket key, uri, etc.).
  - A cronjob runs daily deleting files from the media store that haven't been loaded for a while, and saving them to S3 (in tmy case R2).
  - If someone scrolls back to where these files are, they are loaded back.

## Config/Run

You just gotta make sure that your homeserver config (e.g. `/data/homeserver.yaml`) has the [synapse-s3-storage-provider](https://github.com/matrix-org/synapse-s3-storage-provider) configured with at least the following keys:

- `bucket`
- `endpoint_url`
- `access_key_id`
- `secret_access_key`

You can find an example script to run as a daily cronjob [here](./matrix_cleanup.cron.sh). This scripts offloads files that haven't been loaded in at least 7 days.
