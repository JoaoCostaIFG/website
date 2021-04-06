<?php
$title="PlantUML";
require_once '../../templates/tpl_header.php';
?>

<h2>Draw UML diagrams with PlantUML</h2>

<h3>Context</h3>

<p>
  The second semester is starting and I now have a Data-Bases class (will refer
  to it as BDAD from here on). In this class we're making heavy use of
  <a href="https://www.uml-diagrams.org/">UML</a>, more specifically
  <a href="https://www.uml-diagrams.org/class-diagrams-overview.html"
    >UML class diagrams</a
  >. I am using PlantUML for that, so I'll talk about it and why I chose it.
</p>

<h3>How I've used UML before</h3>

<p>
  Up until this semester, I haven't used UML that much. As a matter of fact, I
  only used UML for a project on the last semester and it was a really limited
  UML application. Even with this new university class, I've been drawing my UML
  with pencil and paper (like most people I see). Needless to say that this
  isn't exactly efficient, specially when I need to correct mistakes.<br />
  Before talking about <a href="https://plantuml.com/"><b>PlantUML</b></a
  >, I believe I should talk about the other alternatives I've tried that (I
  liked) and why I didn't stick to them.
</p>

<h3><a href="https://www.draw.io">draw.io</a></h3>

<p>
  <b>Draw.io</b> is great for those moments when you're not in your usual
  working environment and need a quick diagram drawing tool, or when you only
  need to draw diagrams very sporadically.<br />
  It is most often used as a web-application, but it also has a desktop version
  that I never tried. From what a friend told me, it is the same as the web app,
  but it can be used offline.
</p>

<p>The things I loved the most about <b>draw.io</b> are:</p>
<ul>
  <li>It is open <a href="https://github.com/jgraph/drawio">source</a>;</li>
  <li>
    It is an instance of what I like calling <i>"a good web app"</i>. It works
    on the <a href="https://www.torproject.org">Tor browser</a>, even with all
    cookies blocked and non-free <b>javascript</b> disabled;
  </li>
  <li>It is extremely user-friendly and <i>straight to the point</i>.</li>
</ul>

<p>
  My problem with it was that it didn't support <i>association classes</i>: it
  neither has the type of arrows needed, nor allows to connect an arrow to
  another.
</p>

<h3><a href="https://www.modelio.org/">Modelio</a></h3>

<p>
  I'm going to be honest, I didn't have high expectations for this one since it
  was recommended by my teachers. Still, it is open-source, extensible, and
  seems to have a decent community that keeps the project alive.
</p>

<p>
  It had a lot of dependencies that I didn't have installed and was extremely
  slow when creating a project on my machine, so I gave up on it. I thought
  about not listing it here since I almost didn't try it. Still, I believe you
  should give it a try if you're looking for a GUI application, because you
  might have more luck with it than I did.
</p>

<h3><a href="https://wiki.gnome.org/Apps/Dia">Dia</a></h3>

<p>
  I thought I was going to hate <b>dia</b> (because Gnome), but it surprised me.
  I didn't need to install any dependencies and the GUI was simple and fast.
  Even without having ever looked/read about at it before, all options I wanted
  were in the places I expected them to be.
</p>

<p>
  It is an
  <a href="https://gitlab.gnome.org/GNOME/dia">open-source</a> project, but
  looks a bit abandoned. The few recent commits are mostly fixes/additions to
  translation efforts. Either way, it looks fairly complete.
</p>

<p>
  Remember the <i>association classes</i> problem I had with <b>draw.io</b>? I
  had the same problem with <b>dia</b>. I found
  <a
    href="https://stackoverflow.com/questions/6139951/how-to-draw-an-association-class-in-dia/14344657#14344657"
    >this</a
  >
  answer on a <i>stackoverflow</i> post dating back to the beginning of 2013. It
  says that the <i>development branch</i> of <b>dia</b> added the ability to
  connect UML arrows to one another.<br />
  I cloned and built the <i>development branch</i> and I can confirm that it
  does indeed add that ability. The question now is why isn't this function in
  the <i>release/master</i> branch after (at least) 7 years.<br />
  Anyway, <b>dia</b> doesn't have the UML arrow I need for this either way, so
  it didn't solve the problem completely. The auto-routing is also somewhat bad,
  which meant the search would go continue.
</p>

<h3><a href="https://umbrello.kde.org/">Umbrello</a></h3>

<p>
  This program is amazing and I recommend it to anyone that feels comfortable
  using GUI's and doesn't care about program sizes. It is open-source, supports
  code translation from and to UML for many programming languages, and can
  easily and seamlessly handle UML
  <i>association classes</i> and their arrows.
</p>

<p>
  Although <b>umbrello</b> has all this great things, it is huge. Definitely too
  huge for me and for what I think it should be. In my machines, I need to
  install <b>32</b> dependencies to use <b>umbrello</b>, so I stuck with
  <b>dia</b> for a while.
</p>

<h3>Goodbye GUI's</h3>

<p>
  So after all that search, I kept using <b>dia</b> on the
  <i>development branch</i> with some weird arrows (that weren't even on the UML
  set) to connect the <i>association classes</i>. It was still better than
  drawing everything by hand.<br />
  When I'm drawing a UML <i>class diagram</i> from a textual description (BDAD
  exercises), I start by writing a <i>relational model</i> as I'm reading the
  text. This got me thinking. I had read about drawing UML diagrams in LaTeX
  before. Maybe I would be able to combine the steps of writing the
  <i>relational model</i> and drawing the <i>class diagram</i> into one (and
  show off to my friends). Turns out I can with <b>PlantUML</b>.
</p>

<h4><a href="https://plantuml.com/">PlantUML</a></h4>

<p>
  <b>PlantUML</b> is open-source and strives to be as compact as possible. This
  means that you only have the base set of features by default (which means
  you're just missing some output formats). If you want/need some other
  features, you can install the dependencies. I love this design choice.
</p>

<p>
  The greatest thing about <b>PlantUML</b> is that you describe the UML diagrams
  using a special textual syntax (similar to a scripting language). I know this
  may sound really weird (it sounded weird to me), but it's great. You can draw
  UML diagrams faster than with GUI applications and still watch live previews
  of your work:
</p>

<ul>
  <li>
    a
    <a href="https://marketplace.visualstudio.com/items?itemName=jebbs.plantuml"
      >VSCode extension</a
    >;
  </li>
  <li>
    many vim plugins like:
    <a href="https://github.com/weirongxu/plantuml-previewer.vim"
      >plantuml previewer vim</a
    >,
    <a href="https://github.com/aklt/plantuml-syntax">plantuml-syntax</a>
    and
    <a href="https://github.com/scrooloose/vim-slumlord">vim-slumlord</a>;
  </li>
  <li>
    output the UML to PDF and use a PDF viewer that can update the shown
    contents automatically, like
    <a href="https://en.wikipedia.org/wiki/Zathura_(document_viewer)">Zathura</a
    >: <code>plantuml -tpdf &lt;file_name&gt;</code>;
  </li>
  <li>use the included <b>PlantUML</b> GUI: <code>plantuml -gui</code>;</li>
  <li>just output to default png format and use an image viewer;</li>
  <li>integrates with <a href="https://plantuml.com/latex">LaTeX</a>;</li>
  <li>
    or try one of the
    <a href="https://plantuml.com/running">tools</a> listed on their website.
  </li>
</ul>

<p>
  There are also <a href="https://plantuml.com/running">tools</a> for generation
  code from and to <b>PlantUML</b> like
  <a href="https://github.com/thibaultmarin/hpp2plantuml">hpp2plantuml</a>.
</p>

<h4>PlantUML's examples</h4>

<pre><code class="language-js">
@startuml
title Basic syntax example

'this is a comment'
class Name {
  name
}

class ID {
  id
}

/'
this is a class with some parameters
and 1 method
'/
class Person {
  name
  id
  getID()
}

'these are generalization arrows'
Person &lt;|-- Name
'this arrow has the same meaning as the one above'
Person ^-- ID

'this is an association arrow'
Person - Car
'this is an association class arrow'
(Person, Car) .. IsOwner

@enduml
</code></pre>

The 'code' above is a really simple example of PlantUML's syntax that produces
the following image when the command
<code>plantuml &lt;file_name&gt;</code> is run:
<center>
  <img
    src="/static/img/plantuml/basic_uml_eg.png"
    alt="Basic UML example"
    style="max-width: 80%; height: auto;"
  />
</center>

The <a href="https://bschwarz.github.io/puml-themes/">colors/themes</a> are all
customizable, you can define the directions of the arrows, and you can tell
<b>PlantUML</b> to group certain 'objects' together, so you can end up with
something that looks like this (I'm sorry for your eyes):
<center>
  <img
    src="/static/img/plantuml/ugly_colors_eg.png"
    alt="Ugly colors example"
    style="max-width: 80%; height: auto;"
  />
</center>

This is the 'new code' to get the result above:

<pre><code class="language-js">
@startuml

skinparam backgroundcolor Black/Orange

skinparam class {
	BackgroundColor PaleGreen
	ArrowColor SeaGreen
	BorderColor SpringGreen
}

title Ugly colors example\nwith arrow directions

'this is a comment'
class Name {
  name
}

class ID {
  id
}

/'
this is a class with some parameters
and 1 method
'/
class Person {
  name
  id
  getID()
}

'you can change the direction of arrows'
Name -down-^ Person
'you can abreviate (d)own, (u)p, (l)eft and (r)ight'
Person ^-u- ID

'this is an association arrow'
Person -l- Car
'this is an association class arrow'
(Person, Car) .. IsOwner

@enduml
}
    </code></pre>

I'm not going to talk about all the syntax in depth because I don't need to.
<b>PlantUML's</b>
<a href="https://plantuml.com/sitemap-language-specification"
  >language specification</a
>
is very well written, explicit and filled with examples. The syntax is so simple
and easy that you should be able to start drawing mundane UML
<i>class diagrams</i> just by looking at the examples above and checking the
syntax for the different
<a href="https://plantuml.com/class-diagram">UML arrows</a>. It really is that
easy.

<h4>The bad</h4>

If you're collaborating with other people, you'll probably not be able to get
them to use <b>PlantUML</b>, considering that most people prefer GUI's for
everything. This means that you'll likely only benefit from the time invested
learning the syntax when working in personal projects. Although the auto-routing
is quite good (most of the time), and you have options to group 'objects' and
choose the direction of the arrows, I still find that the diagrams don't always
look perfect. I believe this probably happens because I'm a new user, so I'm
just missing experience with the program to get everything looking the way I
want. Either way, this is the biggest barrier to entry on <b>PlantUML</b>. You
have to rely quite a lot on the auto-routing because you can't simply drag the
connections around. Sadly, it looks like <b>PlantUML</b> doesn't support (at the
time of writing)
<a href="https://www.uml-diagrams.org/property.html#qualifier"
  ><i>association qualifiers</i></a
>. Good thing I haven't needed them (yet).

<h3>Closing remarks</h3>

After a lot of reading, searching, and trying out different programs, I found
<b>PlantUML</b> and I'm in love with it. It reminds me a lot of when I first
used <b>markdown</b>. I was skeptical, but ended up liking it. If you need to
draw UML diagrams for a project and you can decide the tool used, I recommend
<b>PlantUML</b>. It is fun, simple to use, free, it feels familiar to
programming, and it has many tools, plugins and programs that integrate with it.
It is just great. This post wasn't very 'technical', because I didn't find the
need for it. I just wanted to share my opinions on <b>PlantUML</b> and maybe
convince people to use it. I wouldn't be able to do a better job at explaining
how to use <b>PlantUML</b> than its
<a href="https://plantuml.com/sitemap-language-specification"
  >documentation/language specification</a
>. On another note, I started using a <i>Makefile</i> to deploy my website
changes, instead of my
<a href="https://www.joaocosta.dev/blog/how_create_page/#my-deploy-script"
  >old deploy script</a
>. I'm still pondering if I should edit that post, so it would also include the
_Makefile_, but for now I'll leave it here.

<pre><code class="language-js">
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
</code></pre>

Stay safe :P

<?php
require_once '../../templates/tpl_footer.php';
?>
