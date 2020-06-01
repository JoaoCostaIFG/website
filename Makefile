blog_index:
	@rm -f "content/blog.html"
	@echo "Updating blog index."
	@build_res/scripts/update_blog_index.sh

build: clean blog_index
	@echo "Building page."
	@build_res/scripts/build_pages.sh
	@echo "Copying stylesheet."
	@cp build_res/style.css build/
	@cp build_res/favicon.png build/

clean:
	@echo "Cleaning."
	@rm -rf build/

new:
	@build_res/scripts/new_blog.sh

server: build
	@echo "Running server."
	@build_res/scripts/server_loop.sh

deploy: build
	@echo "Deploying."
	@echo "Removing old build."
	@ssh ifgsv 'rm -rf /var/www/joaocosta.dev/main/*'
	@echo "Sending new build."
	@scp -r build/* ifgsv:/var/www/joaocosta.dev/main/

.PHONY: blog_index build clean deploy new server
