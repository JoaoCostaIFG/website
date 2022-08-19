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
    <a class="btn bg-primary-500 hover:bg-primary-400 dark:bg-primary-600 dark:hover:bg-primary-700"
        href="<?php echo route('blog_insert_route'); ?>">
      Add New Post
    </a>
  </div>
<?php } ?>

<?php layout_footer(); ?>
