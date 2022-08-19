<?php $w = $args['w'] ?>
<li>
  <a href="<?= route_args('workshop_route', array('name' => $w['name'])); ?>"><?= $w['title']; ?></a>
  - <span class="muted"><?= $w['date']; ?></span>
</li>
