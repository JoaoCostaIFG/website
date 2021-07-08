<?php layout_header('Projects'); ?>

<h2>Projects</h2>

<?php if (is_auth()) { ?>
  <a href="<?php echo route('proj_insert_route'); ?>">+</a>
<?php } ?>

<p>
  The following are some projects I've created/worked on that I feel proud of.
</p>


<?php
foreach ($args['ps'] as $p) {
  partial_args('projs/entry.php', array('p' => $p));
}
?>

<?php layout_footer(); ?>
