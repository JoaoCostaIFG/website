<?php layout_header('Workshops'); ?>

<h1>My workshop presentations material</h1>

<ul class="prose">
  <?php partial_args(
    'workshops/workshop_entry.php',
    array(
      'w' =>
      array(
        'name' => 'shellscript',
        'title' => 'Shell scripting workshop',
        'date' => '2020-11-01'
      )
    )
  ); ?>
  <?php partial_args(
    'workshops/workshop_entry.php',
    array(
      'w' =>
      array(
        'name' => 'intropython3',
        'title' => 'Introduction to python3 workshop',
        'date' => '2019-11-15'
      )
    )
  ); ?>
</ul>

<?php layout_footer(); ?>
