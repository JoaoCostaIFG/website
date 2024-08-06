#!/bin/sh

set -eu

get_value_from_config() {
  key="$1"
  config_file="$2"
  grep "${key}:" "$config_file" | cut -d':' -f2- | sed -e 's/^[[:space:]]*//'
}

get_value_from_config_mandatory() {
  key="$1"
  config_file="$2"
  v="$(get_value_from_config "$key" "$config_file")"
  if [ -z "$v" ]; then
    echo "No '${key}' in config file: ${config_file}. Exiting.."
    exit 1
  fi
  echo "$v"
}

S3_MEDIA_UPLOAD="s3_media_upload --no-progress"

if [ ${SYNAPSE_CONFIG_PATH+x} ]; then
  config_file="$SYNAPSE_CONFIG_PATH"
elif [ ${SYNAPSE_CONFIG_DIR+x} ]; then
  config_file="${SYNAPSE_CONFIG_DIR}/homeserver.yaml"
else
  config_file="/data/homeserver.yaml"
fi
data_dir="${SYNAPSE_DATA_DIR:-/data}"

media_store_path="$(get_value_from_config 'media_store_path' "$config_file")"
if [ -z "$media_store_path" ]; then
  media_store_path="${data_dir}/media_store"
fi

storage_class="$(get_value_from_config 'storage_class' "$config_file")"
if [ -z "$storage_class" ]; then
  storage_class="STANDARD"
fi

bucket="$(get_value_from_config_mandatory 'bucket' "$config_file")"
endpoint_url="$(get_value_from_config_mandatory 'endpoint_url' "$config_file")"
access_key_id="$(get_value_from_config_mandatory 'access_key_id' "$config_file")"
secret_access_key="$(get_value_from_config_mandatory 'secret_access_key' "$config_file")"

cd "$data_dir"

$S3_MEDIA_UPLOAD update "$media_store_path" "${UPDATE_DURATION:-2d}"
export AWS_ACCESS_KEY_ID="$access_key_id" \
  AWS_SECRET_ACCESS_KEY="$secret_access_key"
$S3_MEDIA_UPLOAD upload "$media_store_path" "$bucket" --storage-class "$storage_class" --delete --endpoint-url "$endpoint_url"
