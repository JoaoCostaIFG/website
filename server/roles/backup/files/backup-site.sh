#!/bin/sh

docker run --rm -v site_app_data:/site_app_data -v site_tor_data:/site_tor_data -v "$(pwd)":/backup backupcontainer
tar -czf bw-data.gz /bw-data
