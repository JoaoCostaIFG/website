<?php layout_header('Home'); ?>

<h2>Welcome to my personal webs page/blog</h2>

My name is João Costa and this is my personal corner of the internet.

<h3>Recent blog posts</h3>
<ul>
  <?php
  foreach ($args['bs'] as $b) {
    partial_args('blog/entry.php', array('b' => $b));
  }
  ?>
</ul>
<a href="<?php echo route('blog_index_route') ?>">see more</a>

<h3><a href="https://wiki.joaocosta.dev">Wiki</a></h3>

I manage a small <a href="https://wiki.joaocosta.dev">wiki</a> with a friend of
mine where we post small "cookbooks", "cheatsheets" and other general
guides/annotations about things we've had to work/deal with in the past and
would like to have an easy to follow guide in the future. Editing of the wiki is
restricted to us but you reading is public. We host a
<a href="https://www.dokuwiki.org/dokuwiki">Dokuwiki</a>
instance for it.

<?php layout_footer(); ?>
