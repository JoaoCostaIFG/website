<?php layout_header('Projects'); ?>

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

<div class="text-center mt-4">
  <?php if (is_auth()) { ?>
    <a class="btn btn-primary" href="<?php echo route('proj_insert_route'); ?>">Add New Proj</a>
  <?php } ?>
</div>

<?php layout_footer(); ?>
