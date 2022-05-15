#!/bin/sh

set -e

db_file="db.db"
db_path="/var/lib/joaocosta.dev/main/database/${db_file}"

sqlite3 "$db_path" ".backup ${db_file}.bak"
gzip -c "${db_file}.bak" >"${db_file}.gz"
rm "${db_file}.bak"
