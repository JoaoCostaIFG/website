<li>
  <a href="<?php echo route_args('blog_post_route', array('id' => $args['b']->getId())) ?>">
    <?php echo $args['b']->getTitle(); ?>
  </a> - <?php echo $args['b']->getDateStr(); ?>
</li>
