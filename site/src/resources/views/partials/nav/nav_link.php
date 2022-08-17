<?php if ($args['selected']) { ?>
  <a class="bg-gray-900 block text-white px-2 py-2 rounded-md text-sm" href="<?= $args['href']; ?>" aria-current="page">
    <?= $args['title'] ?>
  </a>
<?php } else { ?>
  <a class="text-gray-300 block hover:bg-gray-700 hover:text-white px-2 py-2 rounded-md text-sm" href="<?= $args['href']; ?>">
    <?= $args['title'] ?>
  </a>
<?php } ?>
