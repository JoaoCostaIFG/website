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
