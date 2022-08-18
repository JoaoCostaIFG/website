<?php layout_header('Home'); ?>

<h1>Welcome to my corner of the Internet!</h1>

<div class="grid grid-cols-12 gap-x-1 gap-y-4">
  <section class="col-span-12 md:col-span-7">
    <h2>Recent posts</h2>
    <ul class="list-unstyled">
      <?php
      foreach ($args['bs'] as $b) {
        partial_args('blog/entry.php', array('b' => $b));
      }
      ?>
    </ul>
    <a href="<?php echo route('blog_index_route') ?>">(see more)</a>
  </section>

  <section class="col-span-12 md:col-span-5">
    <h2>About</h2>
    <p>
      Hey! My name is João Costa and this is my personal corner of the internet.
    </p>
    <p>
      I'm interested in computer science and electronics, and I enjoy implementing my own solutions to problems/needs.
    </p>
    <p>
      This page's main focus is for me to share some ideas/processes behind projects that I've worked on.
    </p>
    <a href="<?= route('about_route'); ?>">(see more about me)</a>
  </section>

  <section class="col-span-12">
    <h2><a href="https://wiki.joaocosta.dev">Wiki</a></h2>
    <p>
      I manage a small <a href="https://wiki.joaocosta.dev">wiki</a> with a couple of friends where we post small
      "cookbooks", "cheat-sheets" and other general guides/annotations. These focus on things we've had to work/deal
      with in the past and would like to have an easy-to-follow guide in the future. Although editing of the wiki is
      restricted, reading is public to everyone. The wiki is powered by <a href="https://www.dokuwiki.org/dokuwiki">Dokuwiki</a>.
    </p>
  </section>
</div>

<?php layout_footer(); ?>
