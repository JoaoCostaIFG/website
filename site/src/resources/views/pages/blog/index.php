<?php layout_header('Blog'); ?>

<h1>All of my blog posts</h1>

<div class="grid grid-cols-1 gap-y-2">
  <?php
  foreach ($args['bs'] as $b) {
    partial_args('blog/entry.php', array('b' => $b));
  }
  ?>
</div>

<?php if (is_auth()) { ?>
  <div class="text-right mt-4">
    <a class="btn btn-primary" href="<?php echo route('blog_insert_route'); ?>">
      Add New Post
    </a>
  </div>
<?php } ?>

<?php layout_footer(); ?>
