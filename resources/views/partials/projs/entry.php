<h3>
  <a href="<?= $args['p']->getUrl(); ?>"><?= $args['p']->getTitle(); ?></a>
</h3>

<img alt="<?= $args['p']->getTitle() ?>" src="<?= img('projects/' . $args['p']->getImg()); ?>" width="128">
<p>
  <?= Parsedown::instance()->line($args['p']->getDescription()); ?>
</p>
