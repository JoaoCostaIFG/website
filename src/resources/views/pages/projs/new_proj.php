<?php layout_header('New project'); ?>

<h2>New project</h2>

<form method="POST" action="<?=route('proj_insert_action');?>" enctype="multipart/form-data">
  <?=partial('csrf.php');?>

  <label for="title"><b>Title *</b></label>
  <input type="text" id="title" name="title" placeholder="Proj title..." required autofocus><br>
  <label for="description"><b>Description</b></label>
  <textarea id="description" name="description" rows="20" placeholder="Proj description..."></textarea><br>
  <label for="url"><b>Url *</b></label>
  <input type="url" id="url" name="url" placeholder="Proj url..." required><br>
  <label for="img"><b>Img *</b></label>
  <input type="file" id="img" name="img" required><br>

  <input type="submit" value="Submit">
</form>

<?php layout_footer(); ?>

