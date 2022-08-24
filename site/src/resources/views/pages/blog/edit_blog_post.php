<?php layout_header('Edit blog post'); ?>

<h1>Edit blog post</h1>

<div class="w-full">
  <form class="m-auto max-w-prose" method="POST" action="<?= route('blog_edit_action'); ?>">
    <?= partial('csrf.php'); ?>
    <input type="hidden" id="id" name="id" value="<?= $args['b']->getId(); ?>">

    <div>
      <label class="form-label form-label-required" for="title">Title</label>
      <input class="form-input" id="title" type="text" name="title" placeholder="Post title..." required autofocus value="<?= $args['b']->getTitle(); ?>">
    </div>

    <div class="mt-6 w-full flex flex-row flex-wrap items-center gap-2">
      <div class="flex-auto min-w-0">
        <label class="form-label" for="date">Date</label>
        <input class="block form-input" type="date" id="date" name="date" value="<?= $args['b']->getDateStr(); ?>">
      </div>

      <label>
        <input class="form-checkbox" id="visibility" type="checkbox" name="visibility" <?php if ($args['b']->isVisible()) echo 'checked'; ?>>
        <span class="ml-1">Publicly visible</span>
      </label>
    </div>

    <div class="mt-6">
      <label class="form-label" for="intro">Intro</label>
      <textarea class="form-input" id="intro" name="intro" rows="3" placeholder="Summary/Introduction..."><?= $args['b']->getIntro(); ?></textarea>
    </div>

    <textarea class="hidden" id="content" name="content" rows="1" required><?= $args['b']->getContent(); ?></textarea>

    <div class="mt-6 text-right">
      <input class="btn btn-primary" type="submit" value="Submit">
    </div>
  </form>

  <div class="mx-auto mt-6" id="editor-container">
  </div>
</div>

<script src="/dist/bundle.js"></script>

<?php layout_footer(); ?>
