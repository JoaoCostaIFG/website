clean:
	@rm -rf ./src/cache

IMAGE_NAME=joaocostaifg/site
# first characters of the current commit hash
IMAGE_TAG=$(shell git rev-parse --short HEAD)

build:
	@echo "Building Docker image ${IMAGE_NAME}:${IMAGE_TAG}, and tagging as latest"
	@docker build -t "${IMAGE_NAME}:${IMAGE_TAG}" .
	@docker tag "${IMAGE_NAME}:${IMAGE_TAG}" "${IMAGE_NAME}:latest"

push: build
	@echo "Pushing docker image"
	@docker push "${IMAGE_NAME}:${IMAGE_TAG}"
	@docker push "${IMAGE_NAME}:latest"

SERVER_SSH=ifgsv

deploy: push
	@echo "Deploying via remote SSH"
	@# sudo won't ask for password for this (server's sudoers file)
	@ssh ${SERVER_SSH} "sudo systemctl restart live-container"

