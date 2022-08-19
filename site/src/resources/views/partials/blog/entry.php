<a class="p-2 rounded-md
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
  <span class="line-clamp-1 lg:line-clamp-2 ml-2 text-foreground-800 dark:text-foreground-400">
    <?= $args['b']->getIntro(); /* Parsedown::instance()->setUrlsLinked(false)->line($args['b']->getIntro()); */ ?>
  </span>
  <span class="muted">
    <?= $args['b']->getDateStr(); ?>
  </span>
</a>
