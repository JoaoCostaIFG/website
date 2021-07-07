<?php layout_header('Blog index'); ?>

<h2>All of my blog posts</h2>

<?php if (is_auth()) { ?>
  <a href="<?php echo route('blog_insert_route'); ?>">+</a>
<?php } ?>


<ul>
  <?php
  foreach ($args['bs'] as $b) {
    partial_args('blog/entry.php', array('b' => $b));
  }
  ?>
</ul>

<?php layout_footer(); ?>
