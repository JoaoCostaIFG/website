blog_index:
	@rm -f "content/blog.html"
	@echo "Updating blog index."
	@build_res/scripts/update_blog_index.sh

build: clean blog_index
	@echo "Building page."
	@build_res/scripts/build_pages.sh
	@echo "Copying stylesheet."
	@cp build_res/style.css build/

clean:
	@echo "Cleaning."
	@rm -rf build/

new:
	@build_res/scripts/new_blog.sh

.PHONY: blog_index build clean
