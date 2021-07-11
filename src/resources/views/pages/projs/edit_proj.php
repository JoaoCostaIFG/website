<?php layout_header('Edit blog post'); ?>

<h2>Edit blog post</h2>

<form method="POST" action="<?= route('proj_edit_action'); ?>" enctype="multipart/form-data">
  <?= partial('csrf.php'); ?>
  <input type="hidden" id="id" name="id" value="<?= $args['p']->getId(); ?>">
  <input type="hidden" id="old_img" name="old_img" value="<?= $args['p']->getImg(); ?>">

  <label for="title"><b>Title *</b></label>
  <input type="text" id="title" name="title" value="<?= $args['p']->getTitle(); ?>" placeholder="Proj title..." required autofocus><br>
  <label for="description"><b>Description</b></label>
  <textarea id="description" name="description" rows="20" placeholder="Proj description..."><?= $args['p']->getDescription(); ?></textarea><br>
  <label for="url"><b>Url *</b></label>
  <input type="url" id="url" name="url" value="<?= $args['p']->getUrl(); ?>" placeholder="Proj url..." required><br>
  <label for="img"><b>Img</b></label>
  <input type="file" id="img" name="img"><br>

  <input type="submit" value="Submit">
</form>

<?php layout_footer(); ?>
