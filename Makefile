clean:
	@rm -rf ./src/cache

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

### DOCKER ###

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
		-v $(CURDIR)/keys/server.crt:/var/lib/joaocosta.dev/certs/cert.pem:ro \
		-v $(CURDIR)/keys/server.key:/var/lib/joaocosta.dev/certs/key.pem:ro \
		"${IMAGE_NAME}:latest"

push: build
	@echo "Pushing docker image"
	@docker push "${IMAGE_NAME}:${IMAGE_TAG}"
	@docker push "${IMAGE_NAME}:latest"

SERVER_SSH=ifgsv

deploy: push
	@echo "Deploying via remote SSH"
	@# sudo won't ask for password for this (server's sudoers file)
	@ssh ${SERVER_SSH} \
		"docker pull ${IMAGE_NAME}:latest && \
			sudo systemctl restart live-container"

