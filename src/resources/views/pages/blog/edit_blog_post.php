<?php layout_header('Edit blog post'); ?>

<h2>Edit blog post</h2>

<form method="POST" action="<?= route('blog_edit_action'); ?>">
  <?= partial('csrf.php'); ?>
  <input type="hidden" id="id" name="id" value="<?= $args['b']->getId(); ?>">

  <div class="row">
    <div class="seven columns">
      <label for="title">Title *</label>
      <input class="u-full-width" type="text" id="title" name="title" value="<?= $args['b']->getTitle(); ?>" placeholder="Post title..." required autofocus>
    </div>
    <div class="five columns">
      <label for="date">Date</label>
      <input type="date" id="date" name="date" value="<?= $args['b']->getDateStr(); ?>">
    </div>
  </div>

  <label for="intro">Intro</label>
  <textarea class="u-full-width" id="intro" name="intro" rows="3" placeholder="Post summary/introduction..."><?= $args['b']->getIntro(); ?></textarea>
  <label for="content">Content *</label>
  <textarea class="u-full-width" id="content" name="content" rows="20" placeholder="Post body..." required><?= $args['b']->getContent(); ?></textarea>

  <label class="u-pull-right">
    <input type="checkbox" id="visibility" name="visibility" <?php if ($args['b']->isVisible()) echo 'checked'; ?>>
    <span>Publicly visible</span>
  </label>

  <input class="button-primary" type="submit" value="Submit">
</form>

<?php layout_footer(); ?>
