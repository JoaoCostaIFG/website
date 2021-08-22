# JoaoCostaIFG website

The source files of my [blog/personal webstie](https://joaocosta.dev).

## Contents of this repository

This repository includes all (currently published) content of my personal
website/blog and the tools I use to write and publish it (including a
[DokuWiki](https://www.dokuwiki.org/dokuwiki) instance).

## The tools I use to publish

The site's back-end is written in PHP. I use some PHP libraries:

- [Parsedown](https://parsedown.org/) - This is used to render the markdown
  content of the blog posts and projects description.
- [Symfony routing component](https://symfony.com/doc/current/routing.html) -
  This is used for routing and rich URLs. Symfony's yaml, config, and
  http-foundation components are also used for this end.

Front-end dependencies:

- [Skeleton CSS](http://getskeleton.com/) - This is used as the basis of the
  site's CSS.
- [Prism.js](https://prismjs.com/) - This is used for code blocks syntax
  highlighting (Okaidia theme).
- [Remark](https://github.com/gnab/remark) - This is used for the workshop's
  slideshow presentations.

The website is deployed using a [Docker](https://www.docker.com/) container
based on an [Alpine Linux](https://www.alpinelinux.org/) image. Three processes
run on this container: [nginx](https://nginx.org/en/) (HTTP server),
[php-fpm](https://php-fpm.org/) (use PHP on nginx), and
[tor](https://community.torproject.org/) (Onion service for the website).  
In order to have these two processes run in the manner I want, I use
[s6-overlay](https://github.com/just-containers/s6-overlay) (init scripts and
process supervisor).

The website uses a [SQLite database](https://sqlite.org/index.html).

## Cool resources

- [Example HTML boilerplate](https://www.matuzo.at/blog/html-boilerplate/).
- [Example usage of Symfony's routing component](https://code.tutsplus.com/tutorials/set-up-routing-in-php-applications-using-the-symfony-routing-component--cms-31231).
- [HTTPS on local dev env](https://www.freecodecamp.org/news/how-to-get-https-working-on-your-local-development-environment-in-5-minutes-7af615770eec/).
- [Semantic HTML](https://localghost.dev/2021/06/the-right-tag-for-the-job-why-you-should-use-semantic-html/).
- [Set up your Onion service](https://community.torproject.org/onion-services/setup/).

## TODO

- [Emoji domain](https://github.com/jonroig/emojiurlifier) - Self explanatory.
- [Showdown](http://showdownjs.com/) - Markdown render for when I'm writing.
- [File hosting in PHP](https://github.com/Rouji/single_php_filehost) - Could be
  useful.
- [Sqlite pagination](https://github.com/leoshtika/pagination/blob/master/demo-sqlite.php) -
  Blog post index pagination.

## License

Unless stated otherwise, all blog content in this page is licensed under a
[Attribution-ShareAlike 4.0 International](https://creativecommons.org/licenses/by-sa/4.0/)
and the code is licensed under the **GPL3 License** (see LICENSE file).
