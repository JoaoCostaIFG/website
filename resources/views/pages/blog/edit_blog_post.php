<?php layout_header('Edit blog post'); ?>

<h2>Edit blog post</h2>

<form method="POST" action="<?=route('blog_edit_action');?>">
  <?=partial('csrf.php');?>
  <input type="hidden" id="id" name="id" value="<?=$args['b']->getId();?>">

  <label for="title"><b>Title *</b></label>
  <input type="text" id="title" name="title" value="<?=$args['b']->getTitle();?>" placeholder="Post title..." required autofocus><br>
  <label for="intro"><b>Intro</b></label>
  <textarea id="intro" name="intro" rows="3" placeholder="Post summary/introduction..."><?=$args['b']->getIntro();?></textarea><br>
  <label for="content"><b>Content *</b></label>
  <textarea id="content" name="content" rows="20" placeholder="Post body..." required><?=$args['b']->getContent();?></textarea><br>
  <label for="date"><b>Date</b></label>
  <input type="date" id="date" name="date" value="<?=$args['b']->getDateStr();?>"><br>
  <label for="visibility"><b>Publicly visible</b></label>
  <input type="checkbox" id="visibility" name="visibility" <?php if ($args['b']->isVisible()) echo 'checked'; ?>><br>

  <input type="submit" value="Submit">
</form>

<?php layout_footer(); ?>
