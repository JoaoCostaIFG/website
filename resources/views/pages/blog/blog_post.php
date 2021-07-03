<?php 
layout_header($args['b']->getTitle());

echo Parsedown::instance()->text('##' . $args['b']->getTitle());

echo Parsedown::instance()->text($args['b']->getIntro());

echo Parsedown::instance()->text($args['b']->getContent());

layout_footer();
