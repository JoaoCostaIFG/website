<li class="blog-entry">
  <a class="a-unstyled hoverable-bg" href="<?= route_args('blog_post_route', array('id' => $args['b']->getId())) ?>">
    <span class="blog-entry-title"><?= $args['b']->getTitle(); ?></span>
    <?php if (!$args['b']->isVisible()) echo '(hidden)'; ?>
    <br><span><?= $args['b']->getDateStr(); ?></span>
  </a>
</li>
