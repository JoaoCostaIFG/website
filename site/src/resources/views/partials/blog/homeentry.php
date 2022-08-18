<a class="max-w-xl p-2 rounded-md text-gray-100 bg-gray-600 ring-2 ring-inset ring-green-400 hover:bg-gray-800 hover:ring-green-600"
    href="<?= route_args('blog_post_route', array('id' => $args['b']->getId())) ?>">
  <span class="font-semibold"><?= $args['b']->getTitle(); ?></span><?php if (!$args['b']->isVisible()) echo '(hidden)'; ?>
  <br>
  <span class="text-gray-200"><?= $args['b']->getDateStr(); ?></span>
</a>
