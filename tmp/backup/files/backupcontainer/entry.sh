#!/bin/sh

set -e

# app data
rsync -a -q '/site_app_data' '/backup' --exclude '/site_app_data/main/database/db.db'
sqlite3 '/site_app_data/main/database/db.db' '.backup /backup/site_app_data/main/database/db.db'

# tor data
rsync -a -q '/site_tor_data' '/backup'
