<?php
// look for code blocks (to include syntax highlighting code)
if (strpos($args['b']->getcontent(), '```') !== false) $has_code_blocks = true;
else $has_code_blocks = false;

if ($has_code_blocks) layout_header_args(array('title' => $args['b']->getTitle(), 'css' => ['prism.css']));
else layout_header($args['b']->getTitle());
?>

<div class="w-full">
  <article class="m-auto relative prose blog line-numbers match-braces">
    <?php if (is_auth()) { ?>
      <a class="absolute top-0 right-0 z-10 icon-btn btn-edit" title="Edit post <?= $args['b']->getId() ?>" href="<?= route_args('blog_edit_route', array('id' => $args['b']->getId())); ?>">
        <i class="fa-solid fa-pen-to-square"></i>
      </a>
    <?php } ?>

    <div class="mb-4">
      <h1 class="mb-0">
        <?= Parsedown::instance()->line($args['b']->getTitle()); ?>
      </h1>
      <em class="muted">Avg. <?= $args['b']->readingTime(); ?> minute(s) of reading</em>
    </div>

    <?php if (!is_null($args['b']->getIntro())) { ?>
      <div class="mx-2 p-2 rounded-md bg-background-300 dark:bg-background-900">
        <?= Parsedown::instance()->text($args['b']->getIntro()); ?>
      </div>
    <?php } ?>

    <?= Parsedown::instance()->text($args['b']->getContent()); ?>
  </article>
</div>

<?php

if ($has_code_blocks) layout_footer_args(array('js' => ['prism.js']));
else layout_footer();
