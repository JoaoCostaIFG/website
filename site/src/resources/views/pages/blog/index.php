<?php layout_header('Blog index'); ?>

<h2>All of my blog posts</h2>

<ul class="list-unstyled">
  <?php
  foreach ($args['bs'] as $b) {
    partial_args('blog/entry.php', array('b' => $b));
  }
  ?>
</ul>

<?php if (is_auth()) { ?>
  <a class="button button-primary" href="<?php echo route('blog_insert_route'); ?>">Add new post</a>
<?php } ?>

<?php layout_footer(); ?>
