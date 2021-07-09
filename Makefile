clean_cache:
	rm -rf cache

controller:
	@ read name \
	&& path="App/Controllers/$${name}.php" \
	; [ -f "$$path" ] \
	&& echo "File already exists" \
	|| printf \
	"<?php\n\
\n\
namespace Controllers;\n\
\n\
class %s\n\
{\n\
  public static function show()\n\
  {\n\
    view('%s');\n\
  }\n\
}" "$$name" "$$name" >"$${path}"

docker_build:
	docker build -t joaocostaifg/site .

docker_run:
	docker run -it -p 8080:80 -p 8081:443 \
		-v $(CURDIR)/database:/usr/share/nginx/joaocosta.dev/main/database \
		-v $(CURDIR)/storage:/usr/share/nginx/joaocosta.dev/main/storage \
		joaocostaifg/site

