# Matrix server

Using the following:

- I'm running [Synapse](https://github.com/element-hq/synapse) for the server.
  - This is including [Synapse S3 Storage Provider](https://github.com/matrix-org/synapse-s3-storage-provider) to offload media files to BackBlaze R2 ([see more](./synapse/)).
- The frontend is Element: also a hosting a [Element-web](https://github.com/element-hq/element-web) instance to serve a certain config to clients.
- Privately hosting [synapse-admin](https://github.com/Awesome-Technologies/synapse-admin) for admin tasks.
