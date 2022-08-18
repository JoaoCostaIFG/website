<?php layout_header('Blog'); ?>

<h1>All of my blog posts</h1>

<div class="grid grid-cols-1 gap-y-1">
  <?php
  foreach ($args['bs'] as $b) {
    partial_args('blog/entry.php', array('b' => $b));
  }
  ?>
</div>

<?php if (is_auth()) { ?>
  <a class="button button-primary" href="<?php echo route('blog_insert_route'); ?>">Add new post</a>
<?php } ?>

<?php layout_footer(); ?>
