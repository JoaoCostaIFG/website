<article class="proj-entry">
  <h3>
    <a href="<?= $args['p']->getUrl(); ?>"><?= $args['p']->getTitle(); ?></a>
  </h3>

  <?php if (is_auth()) { ?>
    <a href="<?= route_args('proj_edit_route', array('id' =>  $args['p']->getId())); ?>">Edit</a>
  <?php } ?>

  <img alt="<?= $args['p']->getTitle() ?>" src="<?= img('projects/' . $args['p']->getImg()); ?>">
  <hr>
  <p>
    <?= Parsedown::instance()->line($args['p']->getDescription()); ?>
  </p>
</article>
