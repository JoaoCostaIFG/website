<?php layout_header('404'); ?>

<h1>404 not found D:</h1>

<p>
  You probably shouldn't be here, so if you reached this place using one of the
  buttons/links in my website, let me know so I can fix it :3 <em>thanks</em>
</p>
<p>
  In the mean time, you can click the button bellow to go home:
</p>

<div class="text-center mt-4">
  <a class="btn btn-primary" href="<?= route('home_route'); ?>">
    Go Home
  </a>
</div>

<?php layout_footer(); ?>
