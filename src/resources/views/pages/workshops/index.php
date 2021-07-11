<?php layout_header('Workshops'); ?>

<h2>My workshop presentations material</h2>

<ul>
  <li><a href="<?= route_args('workshop_route', array('name' => 'shellscript')); ?>">Shell scripting workshop</a> - 2020-11-01</li>
  <li><a href="<?= route_args('workshop_route', array('name' => 'intropython3')); ?>">Introduction to python3 workshop</a> - 2019-11-15</li>
</ul>

<?php layout_footer(); ?>
