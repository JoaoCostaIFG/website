<?php layout_header('New blog post'); ?>

<h2>New blog post</h2>

<form method="POST" action="<?= route('blog_insert_action'); ?>">
  <?= partial('csrf.php'); ?>

  <div class="row">
    <div class="seven columns">
      <label for="title">Title *</label>
      <input class="u-full-width" type="text" id="title" name="title" placeholder="Post title..." required autofocus>
    </div>
    <div class="five columns">
      <label for="date">Date</label>
      <input type="date" id="date" name="date">
    </div>
  </div>

  <label for="intro">Intro</label>
  <textarea class="u-full-width" id="intro" name="intro" rows="3" placeholder="Post summary/introduction..."></textarea>
  <label for="content">Content *</label>
  <textarea class="u-full-width" id="content" name="content" rows="30" placeholder="Post body..." required></textarea>

  <label class="u-pull-right">
    <input type="checkbox" id="visibility" name="visibility">
    <span>Publicly visible</span>
  </label>
  <input class="button-primary" type="submit" value="Submit">
</form>

<?php layout_footer(); ?>
