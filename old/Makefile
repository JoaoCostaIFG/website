# your output directory (e.g.: public)
OUTPUT_DIR = public
# your website url (e.g.: www.joaocosta.dev)
CNAME = www.joaocosta.dev

default: server

.PHONY: clean
clean:
	@echo "cleaning"
	@# clean all files (except hidden files like '.git')
	rm -rf ${OUTPUT_DIR}/*
	mkdir -p ${OUTPUT_DIR}
	@# write the CNAME file
	printf "%s" ${CNAME} > ${OUTPUT_DIR}/CNAME

.PHONY: build
build:
	@echo "building"
	hugo -d ${OUTPUT_DIR}

.PHONY: commit
commit:
	git -C ${OUTPUT_DIR} add -A
	git -C ${OUTPUT_DIR} commit -m "Deploy: $(shell date)"
	git -C ${OUTPUT_DIR} push origin master

.PHONY: deploy
deploy: clean build commit

.PHONY: server
server:
	hugo -D server

.PHONY: list
list:
	@echo "clean"
	@echo "build"
	@echo "commit"
	@echo "deploy"
	@echo "server (default)"
