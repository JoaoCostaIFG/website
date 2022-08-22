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

- [TailwindCSS](https://tailwindcss.com) - This is used as the basis of the
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

## SSL certificates

The SSL certificates are issued by [Let's Encrypt](https://letsencrypt.org).

I used to use [certbot](https://certbot.eff.org/) to issue/renew certificates,
but it had poor integration with my DNS provider, so I started using
[acme.sh](https://github.com/acmesh-official/acme.sh). This way, I can renew my
certificates automatically by using my DNS provider's API.

## Cool resources

- [Example HTML boilerplate](https://www.matuzo.at/blog/html-boilerplate/)
- [Example usage of Symfony's routing component](https://code.tutsplus.com/tutorials/set-up-routing-in-php-applications-using-the-symfony-routing-component--cms-31231)
- [HTTPS on local dev env](https://www.freecodecamp.org/news/how-to-get-https-working-on-your-local-development-environment-in-5-minutes-7af615770eec/)
- [Semantic HTML](https://localghost.dev/2021/06/the-right-tag-for-the-job-why-you-should-use-semantic-html/)
- [Set up your Onion service](https://community.torproject.org/onion-services/setup/)

## FontAwesome

I use [FontAwesome](https://fontawesome.com) to display some icons on the
website. [FontAwesome](https://fontawesome.com) is quite big, and I don't have a
Pro License in order to use the _subsetter_ feature. As such, I implemented my
own using the following node packages:

- [@fortawesome/fontawesome-free](https://www.npmjs.com/package/@fortawesome/fontawesome-free)
- [fontawesome-subset](https://github.com/omacranger/fontawesome-subset)
- [sass](https://github.com/sass/sass)
- [csso](https://github.com/css/csso)

### Usage

Running the `fontawesome_subsetter.mjs` script (e.g.,
`node fontawesome_subsetter.mjs`), will generate the webfonts and CSS containing
only the required icons. The icons are specified in the `icons` dictionary
inside the script. This was developed for use in this project only, adapt it to
your needs.

It should be noted that I haven't tested it with icon aliases (names referring
to icons with other names).

## License

Unless stated otherwise, all blog content in this page is licensed under a
[Attribution-ShareAlike 4.0 International](https://creativecommons.org/licenses/by-sa/4.0/)
and the code is licensed under the **GPL3 License** (see LICENSE file).
