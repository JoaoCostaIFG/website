<?php
layout_header($args['b']->getTitle());

if (is_auth()) { ?>
  <a href="<?= route_args('blog_edit_route', array('id' => $args['b']->getId())); ?>">Edit</a>
<?php }

echo Parsedown::instance()->text('##' . $args['b']->getTitle());

if (!is_null($args['b']->getIntro()))
  echo Parsedown::instance()->text($args['b']->getIntro());

echo Parsedown::instance()->text($args['b']->getContent());

layout_footer();
