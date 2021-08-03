    </div>
    <footer class="container">
      <hr />
      <p>
        Copyright (c) 2019, 2020, 2021 <b>João Costa</b><br />
        Verbatim copying and redistribution of this entire page are permitted
        provided this notice is preserved.<br />
        <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License.</a>
      </p>
    </footer>

    <?php
    if (isset($args['js'])) {
      foreach ($args['js'] as $js) { ?>
        <script type="text/javascript" src="<?= res_js($js); ?>"></script>
    <?php }
    } ?>
  </body>
</html>
