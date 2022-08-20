<article class="relative p-3 rounded-lg max-w-xs flex flex-col text-center bg-background-200 hover:bg-background-300 dark:bg-background-900 hover:dark:bg-gray-900">
  <?php if (is_auth()) { ?>
    <a class="absolute -top-4 -right-4 z-10 icon-btn btn-edit" title="Edit project <?= $args['p']->getId() ?>" href="<?= route_args('proj_edit_route', array('id' =>  $args['p']->getId())); ?>">
      <i class="fa-solid fa-pen-to-square"></i>
    </a>
  <?php } ?>

  <h2 class="line-clamp-1 mt-0">
    <a title="<?= $args['p']->getTitle(); ?>" href="<?= $args['p']->getUrl(); ?>"><?= $args['p']->getTitle(); ?></a>
  </h2>

  <div class="bg-contain bg-no-repeat bg-center w-full h-28" title="<?= $args['p']->getTitle() ?>" style="background-image: url(<?= img('projects/' . $args['p']->getImg()); ?>)">
  </div>

  <hr class="border-1 w-full my-4 border-foreground-600 dark:border-foreground-500">
  <div class="prose">
    <?= Parsedown::instance()->line($args['p']->getDescription()); ?>
  </div>
</article>
