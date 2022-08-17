<?php
// look for code blocks (to include syntax highlighting code)
if (strpos($args['b']->getcontent(), '```') !== false) $has_code_blocks = true;
else $has_code_blocks = false;

if ($has_code_blocks) layout_header_args(array('title' => $args['b']->getTitle(), 'css' => ['prism.css']));
else layout_header($args['b']->getTitle());

// title
echo Parsedown::instance()->text('##' . $args['b']->getTitle());

echo '<em>Average ' . $args['b']->readingTime() . ' minute(s) of reading time</em><br><br>';

if (is_auth()) { ?>
  <a class="button button-primary" href="<?= route_args('blog_edit_route', array('id' => $args['b']->getId())); ?>">Edit</a>
<?php }

if (!is_null($args['b']->getIntro()))
  echo Parsedown::instance()->text($args['b']->getIntro());

echo Parsedown::instance()->text($args['b']->getContent());

if ($has_code_blocks) layout_footer_args(array('js' => ['prism.js']));
else layout_footer();
