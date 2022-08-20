<?php layout_header('Projects'); ?>

<div class="relative">
  <?php if (is_auth()) { ?>
    <a class="absolute right-0 icon-btn btn-info" title="Add new project" href="<?php echo route('proj_insert_route'); ?>">
      <i class="fa-solid fa-plus"></i>
    </a>
  <?php } ?>

  <h1>Projects</h1>

  <p>
    The following are some projects I've created/worked on that I feel proud of.
  </p>

  <section id="projs-container" class="mt-4 flex flex-row gap-5 flex-wrap justify-center">
    <?php
    foreach ($args['ps'] as $p) {
      partial_args('projs/entry.php', array('p' => $p));
    }
    ?>
  </section>
</div>

<?php layout_footer(); ?>
