<?php layout_header('Projects'); ?>

<h2>Projects</h2>

<p>
  The following are some projects I've created/worked on that I feel proud of.
</p>

<section id="projs-container">
  <?php
  foreach ($args['ps'] as $p) {
    partial_args('projs/entry.php', array('p' => $p));
  }
  ?>
</section>

<?php if (is_auth()) { ?>
  <a class="button button-primary" href="<?php echo route('proj_insert_route'); ?>">Add new proj</a>
<?php } ?>

<?php layout_footer(); ?>
