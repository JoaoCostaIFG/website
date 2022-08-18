<a class="max-w-xl p-2 rounded-md ring-inset
      bg-background-200 text-foreground-800 dark:bg-background-900 dark:text-foreground-200
      hover:bg-gray-300 dark:hover:bg-gray-800
      hover:ring-2 hover:ring-primary-600 dark:hover:ring-primary-800"
    href="<?= route_args('blog_post_route', array('id' => $args['b']->getId())) ?>">
  <span class="font-semibold"><?= $args['b']->getTitle(); ?></span><?php if (!$args['b']->isVisible()) echo '(hidden)'; ?>
  <br>
  <span class="text-foreground-600 dark:text-foreground-500"><?= $args['b']->getDateStr(); ?></span>
</a>
