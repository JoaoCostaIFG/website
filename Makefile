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


IMAGE_NAME=joaocostaifg/site
# first 7 characters of the current commit hash
IMAGE_TAG=$(shell git rev-parse --short HEAD)

docker_build:
	@echo "Building Docker image ${IMAGE_NAME}:${IMAGE_TAG}, and tagging as latest"
	@docker build -t "${IMAGE_NAME}:${IMAGE_TAG}" .
	@docker tag "${IMAGE_NAME}:${IMAGE_TAG}" "${IMAGE_NAME}:latest"

docker_run:
	@docker run -it --net=host \
		-v $(CURDIR)/database:/usr/share/nginx/joaocosta.dev/main/database \
		-v $(CURDIR)/storage:/usr/share/nginx/joaocosta.dev/main/storage \
		"${IMAGE_NAME}:latest"

docker_push: docker_build
	@echo "Pushing docker image"
	@docker push "${IMAGE_NAME}:${IMAGE_TAG}"
	@docker push "${IMAGE_NAME}:latest"

SERVER_DIR=/usr/share/nginx/joaocosta.dev/main/

deploy:
	@# this rsync command won't remove the links created in the dir
	@rsync --delete -r ./App ./resources ./composer.json ./composer.lock \
		./favicon.ico ./index.php ./robots.txt ifgsv:${SERVER_DIR}
	@ssh ifgsv "cd ${SERVER_DIR} && composer install"

#echo "Deploying via remote SSH"
#ssh -i ssh_key "root@${SERVER_IP}" \
#  "docker pull ${IMAGE_NAME}:${IMAGE_TAG} \
#  && docker stop live-container \
#  && docker rm live-container \
#  && docker run --init -d --name live-container -p 80:3000 ${IMAGE_NAME}:${IMAGE_TAG} \
#  && docker system prune -af" # remove unused images to free up space

