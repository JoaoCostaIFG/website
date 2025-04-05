#!/bin/sh

eval $(ansible-vault decrypt --output - cloudflare.env)
terraform "$@"
