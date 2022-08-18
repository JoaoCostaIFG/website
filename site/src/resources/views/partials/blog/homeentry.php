<a class="max-w-xl p-2 rounded-md ring-inset
      bg-background-200 text-foreground-800 dark:bg-background-900 dark:text-foreground-200
      hover:bg-gray-300 dark:hover:bg-gray-900
      hover:ring-2 hover:ring-primary-500 dark:hover:ring-primary-600"
    href="<?= route_args('blog_post_route', array('id' => $args['b']->getId())) ?>">
  <span class="font-semibold">
    <?= $args['b']->getTitle(); ?>
    <?php if (!$args['b']->isVisible()) { ?>
      <span class="text-red-600 dark:text-red-400"> (hidden)</span>
    <?php } ?>
  </span>
  <br>
  <span class="text-foreground-600 dark:text-foreground-500">
    <?= $args['b']->getDateStr(); ?>
  </span>
</a>
