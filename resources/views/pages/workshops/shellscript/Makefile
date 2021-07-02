all:
	@ssh ifgsv 'rm -rf /usr/share/nginx/joaocosta.dev/main/workshop/*'
	@zip -r presentation.zip gato.gif index.html style.css workshop_shellscript.md remark-latest.min.js
	@scp gato.gif index.html style.css workshop_shellscript.md remark-latest.min.js presentation.zip ifgsv:/usr/share/nginx/joaocosta.dev/main/workshop

.PHONY: all
