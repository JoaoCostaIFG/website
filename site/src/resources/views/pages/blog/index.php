<?php layout_header('Blog'); ?>

<div class="relative">
  <?php if (is_auth()) { ?>
    <a class="absolute right-0 icon-btn btn-info" title="Create new blog post" href="<?php echo route('blog_insert_route'); ?>">
      <i class="fa-solid fa-plus"></i>
    </a>
  <?php } ?>

  <h1>All of my blog posts</h1>

  <div class="grid grid-cols-1 gap-y-2">
    <?php
    foreach ($args['bs'] as $b) {
      partial_args('blog/entry.php', array('b' => $b));
    }
    ?>
  </div>
</div>

<?php layout_footer(); ?>
