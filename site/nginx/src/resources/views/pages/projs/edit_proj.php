<?php layout_header('Edit blog post'); ?>

<h2>Edit blog post</h2>

<form method="POST" action="<?= route('proj_edit_action'); ?>" enctype="multipart/form-data">
  <?= partial('csrf.php'); ?>
  <input type="hidden" id="id" name="id" value="<?= $args['p']->getId(); ?>">
  <input type="hidden" id="old_img" name="old_img" value="<?= $args['p']->getImg(); ?>">

  <div class="row">
    <div class="six columns">
      <label for="title">Title *</label>
      <input class="u-full-width" type="text" id="title" name="title" value="<?= $args['p']->getTitle(); ?>" placeholder="Proj title..." required autofocus>
    </div>
    <div class="six columns">
      <label for="url">Url *</label>
      <input class="u-full-width" type="url" id="url" name="url" value="<?= $args['p']->getUrl(); ?>" placeholder="Proj url..." required>
    </div>
  </div>

  <label for="description">Description</label>
  <textarea class="u-full-width" id="description" name="description" rows="20" placeholder="Proj description..."><?= $args['p']->getDescription(); ?></textarea>
  <label for="img">Img</label>
  <input class="u-full-width" type="file" id="img" name="img"><br>

  <input class="button-primary" type="submit" value="Submit">
</form>

<?php layout_footer(); ?>
