<?php layout_header('New blog post'); ?>

<h1>New blog post</h1>

<div class="w-full">
  <form class="m-auto max-w-prose" method="POST" action="<?= route('blog_insert_action'); ?>">
    <?= partial('csrf.php'); ?>
    <div>
      <label class="form-label form-label-required" for="title">Title</label>
      <input class="form-input" id="title" type="text" name="title" placeholder="Post title..." required autofocus>
    </div>

    <div class="mt-6 w-full flex flex-row flex-wrap items-center gap-2">
      <div class="flex-auto min-w-0">
        <label class="form-label" for="date">Date</label>
        <input class="block form-input" type="date" id="date" name="date">
      </div>

      <label>
        <input id="visibility" type="checkbox" name="visibility">
        <span>Publicly visible</span>
      </label>
    </div>

    <div class="mt-6">
      <label class="form-label" for="intro">Intro</label>
      <textarea class="form-input" id="intro" name="intro" rows="3" placeholder="Summary/Introduction..."></textarea>
    </div>

    <div class="mt-6">
      <label class="form-label form-label-required" for="content">Content</label>
      <textarea class="form-input" id="content" name="content" rows="20" placeholder="Content..." required></textarea>
    </div>

    <div class="mt-6 text-right">
      <input class="btn btn-primary" type="submit" value="Submit">
    </div>
  </form>
</div>

<?php layout_footer(); ?>
