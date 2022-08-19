<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic page needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <?php
  $unique_title = 'Joao Costa';
  $description = 'Hey! I&#39;m a computer engineering student and this is my personal website. I try to be active here.';
  if ($args['title']) {
    $unique_title = $args['title'] . ' | ' . $unique_title;
  }
  ?><title><?= $unique_title; ?></title>
  <meta name="description" content="<?= $description; ?>">
  <meta name="author" content="João Costa">

  <!-- Mobile specific metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" type="text/css" href="<?= res_css('style.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= res_css('print.css'); ?>" media="print">
  <link rel="stylesheet" type="text/css" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <?php
  if (isset($args['css'])) {
    foreach ($args['css'] as $css) { ?>
      <link rel="stylesheet" type="text/css" href="<?= res_css($css); ?>">
  <?php }
  } ?>

  <!-- OpenGraph
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta property="og:title" content="<?= $unique_title; ?>">
  <meta property="og:description" content="<?= $description; ?>">
  <meta property="og:image" content="<?= 'https://joaocosta.dev/identicons/' . urlencode($unique_title) ?>">
  <meta property="og:locale" content="en_GB">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= 'https://joaocosta.dev' . $_SERVER['SCRIPT_NAME']; ?>">
  <meta property="og:site_name" content="Joao Costa">
  <meta name="twitter:card" content="summary">

  <!-- Favicon and RSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" href="/favicon.ico">
  <link rel="alternate" type="application/rss+xml" title="Posts - João Costa" href="<?= route('projects_route'); ?>">

  <!-- JS
  -------------------------------------------------- -->
  <script type="text/javascript">
    function setDarkTheme() {
      document.documentElement.classList.add('dark');
      localStorage.theme = 'dark';

      const themeToggler = document.getElementById("theme-toggler");
      if (themeToggler == null) return;

      const newToggler = document.createElement("button");
      newToggler.onclick = toggleTheme;
      newToggler.classList.add("px-1", "text-cyan-600", "hover:text-cyan-500");
      newToggler.innerHTML = '<i class="fa-solid fa-moon"></i>';

      themeToggler.parentNode.replaceChild(newToggler, themeToggler);
      newToggler.id = "theme-toggler";
    }

    function setLightTheme() {
      document.documentElement.classList.remove('dark');
      localStorage.theme = 'light';

      const themeToggler = document.getElementById("theme-toggler");
      if (themeToggler == null) return;

      const newToggler = document.createElement("button");
      newToggler.onclick = toggleTheme;
      newToggler.classList.add("px-1", "text-yellow-200", "hover:text-yellow-400");
      newToggler.innerHTML = '<i class="fa-solid fa-sun"></i>';

      themeToggler.parentNode.replaceChild(newToggler, themeToggler);
      newToggler.id = "theme-toggler";
    }

    function toggleTheme() {
      if (localStorage.theme === "dark") {
        setLightTheme();
      } else {
        setDarkTheme();
      }
    }

    // call on page load and when changing themes (defaults to dark theme)
    function onThemeChange() {
      if (localStorage.theme === 'light' ||
        (!('theme' in localStorage) && !(window.matchMedia('(prefers-color-scheme: dark)').matches))) {
        setLightTheme();
      } else {
        setDarkTheme();
      }
    }

    // placed inline on head to avoid FOUC
    onThemeChange();
  </script>

  <!-- CSRF
  -------------------------------------------------- -->
  <meta name="csrf-token" content="<?= $_SESSION['csrf']; ?>">
</head>

<body class="bg-background-200 dark:bg-background-900">
  <header id="header-container" class="w-full">
    <nav id="navbar" arial-label="primary navigation" class="bg-navbar-800">
      <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
          <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
            <!-- Mobile menu button-->
            <button type="button" class="sm:hidden py-2 px-3 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 hover:animate-pulse focus:ring-2 focus:ring-inset focus:ring-white" onclick="toggleMobileMenu()" aria-controls="mobile-menu" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <i class="fa-solid fa-bars"></i>
            </button>
          </div>
          <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
            <img id="brand" class="block flex-shrink-0 h-8 w-auto" src="<?= img('irao.png') ?>" alt="My icon">
            <div class="hidden sm:block sm:ml-6">
              <div class="flex space-x-4">
                <?php
                partial_args('nav/nav_link.php', array(
                  'href' => route('home_route'),
                  'title' => "Home", 'selected' => "Home" === $args['title']
                ));
                partial_args('nav/nav_link.php', array(
                  'href' => route('blog_index_route'),
                  'title' => "Blog", 'selected' => "Blog" === $args['title']
                ));
                partial_args('nav/nav_link.php', array(
                  'href' => route('projects_route'),
                  'title' => "Projects", 'selected' => "Projects" === $args['title']
                ));
                partial_args('nav/nav_link.php', array(
                  'href' => route('workshops_route'),
                  'title' => "Workshops", 'selected' => "Workshops" === $args['title']
                ));
                partial_args('nav/nav_link.php', array(
                  'href' => route('about_route'),
                  'title' => "About/Contacts", 'selected' => "About me" === $args['title']
                ));
                ?>
              </div>
            </div>
          </div>

          <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <?php
            partial_args('nav/nav_icon.php', array(
              'title' => "My wiki",
              'href' => "https://wiki.joaocosta.dev", 'icon' => "fa-solid fa-file-pen"
            ));
            partial_args('nav/nav_icon.php', array(
              'title' => "My GitHub page",
              'href' => "https://github.com/JoaoCostaIFG", 'icon' => "fa-brands fa-github"
            ));
            partial_args('nav/nav_icon.php', array(
              'title' => "My blog's RSS",
              'href' => route('rss_route'), 'icon' => "fa-solid fa-square-rss"
            ));
            ?>
            <?php if (is_auth()) { ?>
              <a class="bg-gray-800 px-1 text-red-200 hover:text-red-400" title="logout" href="<?= route('user_logout_route'); ?>">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
              </a>
            <?php } else { ?>
              <a class="bg-gray-800 px-1 text-green-200 hover:text-green-400" title="login" href="<?= route('user_login_route'); ?>">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
              </a>
            <?php } ?>
            <button id="theme-toggler" class="px-1 text-cyan-600 hover:text-cyan-500" onclick="toggleTheme()">
              <i class="fa-solid fa-moon"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu, show/hide based on menu state. -->
      <div id="mobile-menu" class="hidden sm:hidden">
        <div class="px-2 pb-2 space-y-1">
          <?php
          partial_args('nav/nav_link.php', array(
            'href' => route('home_route'),
            'title' => '<i class="fa-solid fa-house w-6"></i> Home',
            'selected' => "Home" === $args['title']
          ));
          partial_args('nav/nav_link.php', array(
            'href' => route('blog_index_route'),
            'title' => '<i class="fa-solid fa-blog w-6"></i> Blog',
            'selected' => "Blog" === $args['title']
          ));
          partial_args('nav/nav_link.php', array(
            'href' => route('projects_route'),
            'title' => '<i class="fa-solid fa-lightbulb w-6"></i> Projects',
            'selected' => "Projects" === $args['title']
          ));
          partial_args('nav/nav_link.php', array(
            'href' => route('workshops_route'),
            'title' => '<i class="fa-solid fa-chalkboard-user w-6"></i> Workshops',
            'selected' => "Workshops" === $args['title']
          ));
          partial_args('nav/nav_link.php', array(
            'href' => route('about_route'),
            'title' => '<i class="fa-solid fa-address-card w-6"></i> About/Contacts',
            'selected' => "About me" === $args['title']
          ));
          ?>
        </div>
      </div>
    </nav>
  </header>

  <div id="content-container" class="container py-4 sm:rounded-b bg-background-100 text-foreground-800 dark:bg-background-800 dark:text-foreground-50">
