blog_index:
	rm "content/blog.html"
	build_res/scripts/update_blog_index.sh

deploy:
	mkdir "build"

.PHONY: blog_index
