#!/bin/sh

printf "%s\\n%s\\n" "consult('/usr/share/nginx/joaocosta.dev/main/static/emulsion/game/prolog/server-swi.pl')." "server." |
  swipl
