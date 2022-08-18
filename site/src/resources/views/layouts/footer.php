  </div>
  <footer class="container">
    <hr class="my-4">
    <p class="text-sm text-gray-600">
      Copyright <a class="text-blue-400" rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons</a> <i class="fa-solid fa-copyright"></i> 2019, 2020, 2021, 2022 <b>João Costa</b>
    </p>
  </footer>

  <!-- JS
  -------------------------------------------------- -->
  <script type="text/javascript">
    // called again here to update theme toggler icon
    onThemeChange();

    function toggleMobileMenu() {
      const mobileMenu = document.getElementById("mobile-menu");
      if (mobileMenu.classList.contains("hidden")) {
        mobileMenu.classList.remove("hidden");
      } else {
        mobileMenu.classList.add("hidden");
      }
    }
  </script>
  <?php
  if (isset($args['js'])) {
    foreach ($args['js'] as $js) { ?>
      <script type="text/javascript" src="<?= res_js($js); ?>"></script>
  <?php }
  } ?>
</body>
</html>
