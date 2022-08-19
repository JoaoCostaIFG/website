<article class="relative p-3 rounded-lg max-w-xs flex flex-col text-center items-center bg-background-900">
  <h2>
    <a href="<?= $args['p']->getUrl(); ?>"><?= $args['p']->getTitle(); ?></a>
  </h2>
  <div class="bg-contain bg-no-repeat bg-center w-full h-28" title="<?= $args['p']->getTitle() ?>" style="background-image: url(<?= img('projects/' . $args['p']->getImg()); ?>)">
  </div>
  <hr class="border-1 w-full my-4">
  <p>
    <?= Parsedown::instance()->line($args['p']->getDescription()); ?>
  </p>
  <?php if (is_auth()) { ?>
    <a class="absolute -top-5 -right-4 z-10 icon-btn btn-edit opacity-50 hover:opacity-100"
        href="<?= route_args('proj_edit_route', array('id' =>  $args['p']->getId())); ?>">
      <i class="fa-solid fa-pen-to-square"></i>
    </a>
  <?php } ?>
</article>
