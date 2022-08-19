<?php layout_header('Workshops'); ?>

<h1>My workshop presentations material</h1>

<ul class="prose">
  <li>
    <a href="<?= route_args('workshop_route', array('name' => 'shellscript')); ?>">Shell scripting workshop</a>
     - <span class="muted">2020-11-01</span>
  </li>
  <li><a href="<?= route_args('workshop_route', array('name' => 'intropython3')); ?>">Introduction to python3 workshop</a> - 2019-11-15</li>
</ul>

<?php layout_footer(); ?>
