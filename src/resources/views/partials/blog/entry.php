<li>
  <a href="<?=route_args('blog_post_route', array('id' => $args['b']->getId())) ?>">
    <?=$args['b']->getTitle();?>
  </a><?php if (!$args['b']->isVisible()) echo ' - hidden';  ?> - <?=$args['b']->getDateStr();?>
</li>
