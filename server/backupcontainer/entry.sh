#!/bin/sh

set -e

# app data
rsync -a -q '/site_app_data' '/backup' --exclude '.backup /site_app_data/main/database/db.db'
sqlite3 '/site_app_data/main/database/db.db' '/backup/site_app_data/main/database/db.db'
tar -czf '/backup/site_app_data.tar.gz' 'backup/site_app_data'
rm -rf '/backup/site_app_data'

# tor data
tar -czf '/backup/site_tor_data.tar.gz' 'site_tor_data'
