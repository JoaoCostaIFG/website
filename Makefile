BUILD_DIR="build"

build: clean blog_index rss
	@echo "Building page."
	@build_res/scripts/build_pages.sh
	@echo "Copying stylesheet."
	@cp build_res/style.css build/
	@cp build_res/favicon.png build/
	@cp atom.xml build/
	@cp robots.txt build/
	@cp -r static/ ${BUILD_DIR}

blog_index:
	@rm -f "content/blog.html"
	@echo "Updating blog index."
	@build_res/scripts/update_blog_index.sh

rss:
	@echo "Updating atom feed."
	@build_res/scripts/rss_gen.sh

clean:
	@echo "Cleaning."
	@rm -rf ${BUILD_DIR}

new:
	@build_res/scripts/new_blog.sh

server: build
	@echo "Running server."
	@build_res/scripts/server_loop.sh

deploy: build
	@echo "Deploying."
	@echo "Removing old build."
	@ssh ifgsv 'rm -rf /usr/share/nginx/joaocosta.dev/main/*'
	@echo "Setting perms."
	@find ${BUILD_DIR}/* -type f -exec chmod 644 '{}' \;
	@find ${BUILD_DIR}/* -type d -exec chmod 755 '{}' \;
	@echo "Sending new build."
	@scp -r build/* ifgsv:/usr/share/nginx/joaocosta.dev/main/

.PHONY: blog_index build clean deploy new rss server
