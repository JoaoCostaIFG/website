<?php layout_header('New blog post'); ?>

<h2>New blog post</h2>

<form method="POST" action="<?php echo route('blog_insert_action'); ?>">
  <label for="title"><b>Title *</b></label>
  <input type="text" id="title" name="title" placeholder="Post title..." required autofocus><br>
  <label for="intro"><b>Intro</b></label>
  <textarea id="intro" name="intro" rows="3" placeholder="Post summary/introduction..."></textarea><br>
  <label for="content"><b>Content *</b></label>
  <textarea id="content" name="content" rows="20" placeholder="Post body..." required></textarea><br>
  <label for="date"><b>Date</b></label>
  <input type="date" id="date" name="date"><br>
  <label for="visibility"><b>Publicly visible</b></label>
  <input type="checkbox" id="visibility" name="visibility"><br>

  <input type="submit" value="Submit">
</form>

<?php layout_footer(); ?>
