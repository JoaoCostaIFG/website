clean_cache:
	rm -rf cache

controller:
	@ read name \
	&& path="src/App/Controllers/$${name}.php" \
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


IMAGE_NAME=joaocostaifg/site
# first characters of the current commit hash
IMAGE_TAG=$(shell git rev-parse --short HEAD)

build:
	@echo "Building Docker image ${IMAGE_NAME}:${IMAGE_TAG}, and tagging as latest"
	@docker build -t "${IMAGE_NAME}:${IMAGE_TAG}" .
	@docker tag "${IMAGE_NAME}:${IMAGE_TAG}" "${IMAGE_NAME}:latest"

run:
	@docker run -it -p 80:80 -p 443:443 \
		-v $(CURDIR)/src/database:/var/lib/joaocosta.dev/main/database \
		-v $(CURDIR)/src/storage:/var/lib/joaocosta.dev/main/storage \
		-v $(CURDIR)/keys/server.crt:/var/lib/joaocosta.dev/certs/server.pem \
		-v $(CURDIR)/keys/server.key:/var/lib/joaocosta.dev/certs/server_key.pem \
		"${IMAGE_NAME}:latest"

push: build
	@echo "Pushing docker image"
	@docker push "${IMAGE_NAME}:${IMAGE_TAG}"
	@docker push "${IMAGE_NAME}:latest"

SERVER_SSH=ifgsv

deploy: push
	@echo "Deploying via remote SSH"
	ssh ${SERVER_SSH} \
	  "docker pull ${IMAGE_NAME}:latest && \
			docker stop live-container; \
	  	docker rm live-container; \
			docker run -d --name live-container -p 80:80 -p 443:443 \
        -v /var/lib/joaocosta.dev/main/database:/var/lib/joaocosta.dev/main/database \
        -v /var/lib/joaocosta.dev/main/storage:/var/lib/joaocosta.dev/main/storage \
        -v /etc/letsencrypt/live/joaocosta.dev/fullchain.pem:/var/lib/joaocosta.dev/certs/server.pem:ro \
        -v /etc/letsencrypt/live/joaocosta.dev/privkey.pem:/var/lib/joaocosta.dev/certs/server_key.pem:ro \
        -v /var/lib/joaocosta.dev/wiki:/var/lib/joaocosta.dev/wiki \
        ${IMAGE_NAME}; \
	  	docker system prune -af"

