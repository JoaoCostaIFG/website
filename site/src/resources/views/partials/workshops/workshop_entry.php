<?php $w = $args['w'] ?>
<li>
  <a class="anchor" href="<?= route_args('workshop_route', array('name' => $w['name'])); ?>"><?= $w['title']; ?></a>
  - <span class="muted"><?= $w['date']; ?></span>
</li>
