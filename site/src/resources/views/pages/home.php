<?php layout_header('Home'); ?>

<h2>Welcome to my corner of the net!</h2>

<div class="row">
  <section class="seven columns">
    <h3>Recent posts</h3>
    <ul class="list-unstyled">
      <?php
      foreach ($args['bs'] as $b) {
        partial_args('blog/entry.php', array('b' => $b));
      }
      ?>
    </ul>
    <a href="<?php echo route('blog_index_route') ?>">(see more)</a>
  </section>

  <section class="five columns">
    <h3>About</h3>
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

  <section class="twelve columns">
    <h3><a href="https://wiki.joaocosta.dev">Wiki</a></h3>
    <p>
      I manage a small <a href="https://wiki.joaocosta.dev">wiki</a> with a couple of friends where we post small
      "cookbooks", "cheatsheets" and other general guides/annotations about things we've had to work/deal with
      in the past and would like to have an easy to follow guide in the future. Editing of the wiki is restricted
      to us, but reading is public. <a href="https://www.dokuwiki.org/dokuwiki">Dokuwiki</a> is the software
      powering it.
    </p>
  </section>
</div>


<?php layout_footer(); ?>
