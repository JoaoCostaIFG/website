<?php layout_header('New project'); ?>

<h2>New project</h2>

<form method="POST" action="<?= route('proj_insert_action'); ?>" enctype="multipart/form-data">
  <?= partial('csrf.php'); ?>

  <div class="row">
    <div class="six columns">
      <label for="title">Title *</label>
      <input class="u-full-width" type="text" id="title" name="title" placeholder="Proj title..." required autofocus>
    </div>
    <div class="six columns">
      <label for="url">Url *</label>
      <input class="u-full-width" type="url" id="url" name="url" placeholder="Proj url..." required>
    </div>
  </div>

  <label for="description">Description</label>
  <textarea class="u-full-width" id="description" name="description" rows="20" placeholder="Proj description..."></textarea>
  <label for="img">Img *</label>
  <input class="u-full-width" type="file" id="img" name="img" required>

  <input class="button-primary" type="submit" value="Submit">
</form>

<?php layout_footer(); ?>
