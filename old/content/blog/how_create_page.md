---
title: "How I created this web page"
date: 2020-01-30T22:57:54Z
categories: [blog]
tags: [blog, prog, hugo, github-pages]
description: "The blog is quickly approaching what I want it to be, so I can finally
write actual blog posts. So why not start by talking about how this page came to be
and how you can create a similar one."
author: "JoaoCostaIFG"
---

## Initial idea

The blog is quickly approaching what I want it to be, so I can finally write actual
blog posts. So why not start by talking about how this page came to be and how you
can create a similar one.

I have had this domain for around a year by the time of writing but all the plans
I've had for it over the last few months never came to be (personal file server,
email server, etc.). Right now, I'm glad those plans/project ideas never resulted
in anything that used this domain because I'm enjoying writing quite a lot.

The idea of creating a blog came from a [friend of mine](https://github.com/Educorreia932)
that was starting to play around with some **html+css** and **java script** on his
personal web page. It was a small page with a cute spinning backdrop (the backdrop
is controllable now).
Anyway, I started by going through a few tutorials at
[w3schools](https://www.w3schools.com/howto/howto_website.asp) and was making some
progress when I started thinking about how I was going to host this thing.

## GitHub pages and hosting

This is where [github pages](https://pages.github.com/) comes in. Since I was looking
to deploy a simple **personal static** page, [github pages](https://pages.github.com/)
sounded like a great solution (I remembered it from hosting the presentation slides
for a [Python 3 workshop](https://github.com/JoaoCostaIFG/Workshop-Introduction-Python-3)
I lectured).  
Hosting it sounded much scarier than it actually is/was. I followed the following
steps:

- First, you create a repository for your website. Since I wanted it to be my personal
  website, I named it like instructed on the [github pages](https://pages.github.com/)
  page, so _joaocostaifg.github.io_ in my case. It can be either private or
  public, you choose;
  {{< image src="/img/how_create_page/github_pages_reponame.png" alt="Github pages repository name" position="center" style="border-radius: 0px;" >}}

- After that, you go to your newly created github repository settings (probably
  at _github.com/user/user.github.io/settings_, where _user_ is your github
  username) and activate **github pages function**. On the next steps, I'm gonna
  talk about using a custom domain, so the next steps and optional (if you don't
  have/don't want to use a custom domain, you're done with the hosting matter);

- Now that we've activated the **github pages function**, we can give it our
  domain in the **custom domain section**. In my case, this is _joaocosta.dev_.
  As you can see from the image below, the repository can be private;
  {{< image src="/img/how_create_page/github_pages_options.png" alt="Github repository pages options" position="center" style="border-radius: 0px;" >}}

- This is the part that confused me a bit (I had no idea it worked like this).
  You need to go to your domain registrar's website and access your domain's DNS
  setting. When you're there, you need to create **4 A records** with the following
  **IP addresses** and optionally, a **CNAME Record** (185.199.108.153, 185.199.109.153,
  185.199.110.153 185.199.111.153). The **CNAME Record** seems to
  improve [page loading times](https://help.github.com/en/github/working-with-github-pages/about-custom-domains-and-github-pages#www-subdomains)
  among other things (also, **www** seems to be the common and recommended choice).
  I bought my domain at [namecheap](https://www.namecheap.com/) so my DNS settings'
  page look like this:
  {{< image src="/img/how_create_page/namecheap_dns.png" alt="Space Dragon" position="center" style="border-radius: 0px;" >}}

- It should be all good now :D. Remember that if you're using a custom domain,
  it might take a few hours for your certificate to be issued.

Now the fun part begins :3

## Static page generators

I'm not sure if you noticed, but there is a **Theme Chooser** field on the github
pages repository settings. While hosting the page I was working on at the time
(it was a simples html+css page that looked similar to [this page](https://suckless.org/)),
I noticed those theme options and got curious, so I went to check it out.  
Turn out that there are a few **static page generators** nowadays, and they
are extremely popular. I started looking at some of the options and the most
popular seemed to be [HUGO](https://gohugo.io) and [Jekyll](https://jekyllrb.com/).
I picked up [HUGO](https://gohugo.io) because the logo looked cute.

To be honest, when I started thinking about creating my own blog, I never expected
I'd end up using a static page generator (especially considering I didn't know they
existed) but here I am. It still feels a bit like cheating because they make the
process of creating a web page extremely easy (especially considering the all the
[themes](https://themes.gohugo.io/) freely available online) but I'll probably
get over it when I start editing the
[theme that I'm using](https://themes.gohugo.io/hugo-theme-terminal/)
(gotta feel like I did something :/).

Anyway, using HUGO has been super simple and fun. It's easy to write in markdown
and HUGO has tons of features. I thought about talking about how I started using
it but I don't think I can do a better job at explaining stuff than what this 2
guides: [HUGO Quick start](https://gohugo.io/getting-started/quick-start/) and
[HUGO Host on Github](https://gohugo.io/hosting-and-deployment/hosting-on-github/).  
BTW HUGO is cool but Jekyll looked amazing too. Just pick the one you like the most
or try both (I'm too lazy to try both and I'm fairly happy with HUGO _for now_).  
Oh ye, there's also automatically set up RSS feeds with HUGO (it's under **Show more**
on the bar at the top).

### My 'deploy' script

On the [HUGO Host on Github](https://gohugo.io/hosting-and-deployment/hosting-on-github/)
there's a script called _deploy.sh_ that is used to commit the website builds to
the website's repository (using **git submodules**). I had a problem with this script
when deleting pages because they weren't removed from the final build automatically,
so I adapted it to my needs. This is the script I'm using right now:

```shell
#!/bin/sh

# If a command fails then the deploy stops
set -e

printf "\033[0;32mDeploying updates to GitHub...\033[0m\n"

# Delete old files
cd public
for i in $(find . -maxdepth 1 ! -name . ! -name .. ! -name '.git' ! -name 'CNAME'); do
  rm -r "$i"
done
cd ..

# Build the project.
hugo

# Go To Public folder
cd public

# Add changes to git.
git add .

# Commit changes.
msg="rebuilding site $(date)"
if [ -n "$*" ]; then
  msg="$*"
fi
git commit -m "$msg"

# Push source and build repos.
git push origin master
```

This script deletes the old build files (only keeps the **CNAME file** needed by
github pages and the **.git** file/directory (it's a file in case we're using
submodule)), builds the website and commits the final build. Feel free to use it
and change it your needs.

## Closing remarks

Everything seems to be set up to work smoothly from now on, so I'll most likely
start writing post frequently. The most important thing I need to find now is
a tool to check my grammar i.e. if the sentences are constructed correctly (I'm
open to suggestions).

And with this, I end my first real blog post. Feels like this project is going
to be fun.  
Stay safe :P

## EDIT (23/02/2020)

I started using a _Makefile_ to work and deploy the website, instead of my
**deploy script**. After I finished writting my
[**PlantUML** post](https://www.joaocosta.dev/blog/plantuml), I decided to edit
this post to include it.

```bash
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
```
