<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic page needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <?php
  $unique_title = 'Joao Costa';
  $description = 'Hey! I&#39;m a computer engineering student and this is my personal website. I try to be active here.';
  if ($title) {
    $unique_title = $title . ' | ' . $unique_title;
  }
  ?><title><?= $unique_title; ?></title>
  <meta name="description" content="{{ $description }}">
  <meta name="author" content="João Costa">

  <!-- Mobile specific metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  @vite([
  "resources/css/fontawesome.css",
  "resources/css/print.css",
  "resources/css/style.css",
  ])
  @isset($css)
  @foreach ($css as $c)
  <link rel="stylesheet" type="text/css" href="{{ $c }}">
  @endforeach
  @endisset

  <!-- OpenGraph
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta property="og:title" content="{{ $unique_title }}">
  <meta property="og:description" content="{{ $description }}">
  <meta property="og:image" content="{{ 'https://joaocosta.dev/identicons/' . urlencode($unique_title) }}">
  <meta property="og:locale" content="en_GB">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ 'https://joaocosta.dev' . $_SERVER['SCRIPT_NAME'] }}">
  <meta property="og:site_name" content="Joao Costa">
  <meta name="twitter:card" content="summary">

  <!-- Favicon and RSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" href="/favicon.ico">
  <link rel="alternate" type="application/rss+xml" title="Posts - João Costa" href="{{ route('projects') }}">

  <!-- JS
  -------------------------------------------------- -->
  <script type="text/javascript">
    function setDarkTheme() {
      document.documentElement.classList.add('dark');
      localStorage.theme = 'dark';

      const themeToggler = document.getElementById("theme-toggler");
      if (themeToggler == null) return;

      const newToggler = document.createElement("button");
      newToggler.setAttribute('aria-label', "Set light theme");
      newToggler.onclick = toggleTheme;
      newToggler.classList.add("text-xl", "w-5", "text-cyan-600", "hover:text-cyan-500");
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
      newToggler.setAttribute('aria-label', "Set dark theme");
      newToggler.onclick = toggleTheme;
      newToggler.classList.add("text-xl", "w-5", "text-yellow-200", "hover:text-yellow-400");
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
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-background-200 dark:bg-background-900 min-h-screen">
  <header id="header-container" class="w-full">
    <nav id="navbar" arial-label="primary navigation" class="bg-navbar-800">
      <!-- navbar contents -->
      <div class="container mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
          <!-- Mobile menu button-->
          <button type="button" class="absolute left-0 sm:hidden py-2 px-3 rounded-md text-navbar-400 hover:text-white hover:bg-gray-700 focus:ring-2 focus:ring-inset focus:ring-white" onclick="toggleMobileMenu()" aria-label="Open navbar menu" aria-controls="mobile-menu" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
          </button>

          <div class="flex flex-1 justify-center sm:justify-start">
            <a class="shrink-0" title="Go home" href="{{ route('home') }}">
              <img id="brand" class="aspect-square shrink-0 h-8 w-auto" src="irao.png" alt="My icon">
            </a>
            <div class="hidden sm:block sm:ml-2">
              <div class="flex gap-x-2">
                @include('partials.nav.link', ['href' => route('home'), 'title' => 'Home', 'selected' => 'Home' === $title])
                @include('partials.nav.link', ['href' => route('blog_index'), 'title' => 'Blog', 'selected' => 'Blog' === $title])
                @include('partials.nav.link', ['href' => route('projects'), 'title' => 'Projects', 'selected' => 'Projects' === $title])
                @include('partials.nav.link', ['href' => route('workshops'), 'title' => 'Workshops', 'selected' => 'Workshops' === $title])
                @include('partials.nav.link', ['href' => route('about'), 'title' => 'About/Contacts', 'selected' => 'About me' === $title])
              </div>
            </div>
          </div>

          <div class="absolute inset-y-0 right-0 mr-4 sm:mr-0 flex items-center gap-x-4">
            @include('partials.nav.icon', ['href' => 'https://wiki.joaocosta.dev', 'title' => 'My wiki', 'icon' => 'fa-solid fa-file-pen', 'classes' => 'hidden sm:inline-block'])
            @include('partials.nav.icon', ['href' => 'https://github.com/JoaoCostaIFG', 'title' => 'My GitHub page', 'icon' => 'fa-brands fa-github', 'classes' => 'hidden sm:inline-block'])
            @include('partials.nav.icon', ['href' => route('rss'), 'title' => "My blog's RSS", 'icon' => 'fa-solid fa-square-rss', 'classes' => 'hidden sm:inline-block'])
            @if (Auth::check())
            <a class="text-xl w-5 text-red-200 hover:text-red-400" title="logout" href="{{ route('logout') }}">
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
            @else
            <a class="text-xl w-5 text-green-200 hover:text-green-400" title="login" href="{{ route('login') }}">
              <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </a>
            @endif
            <button id="theme-toggler" class="text-xl w-5 text-yellow-200 hover:text-yellow-400" onclick="toggleTheme()" aria-label="Set light theme">
              <i class="fa-solid fa-sun"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- mobile menu (show/hide based on menu state) -->
      <div id="mobile-menu" class="hidden sm:hidden px-2 pb-2 flex flex-col gap-y-1">
        @include('partials.nav.link', ['href' => route('home'), 'title' => '<i class="fa-solid fa-house w-6"></i> Home', 'selected' => 'Home' === $title])
        @include('partials.nav.link', ['href' => route('blog_index'), 'title' => '<i class="fa-solid fa-blog w-6"></i> Blog', 'selected' => 'Blog' === $title])
        @include('partials.nav.link', ['href' => route('projects'), 'title' => '<i class="fa-solid fa-lightbulb w-6"></i> Projects', 'selected' => 'Projects' === $title])
        @include('partials.nav.link', ['href' => route('workshops'), 'title' => '<i class="fa-solid fa-chalkboard-user w-6"></i> Workshops', 'selected' => 'Workshops' === $title])
        @include('partials.nav.link', ['href' => route('about'), 'title' => '<i class="fa-solid fa-address-card w-6"></i> About/Contacts', 'selected' => 'About me' === $title])
        <div class="flex flex-row justify-around flex-wrap gap-x-4">
          @include('partials.nav.icon', ['href' => 'https://wiki.joaocosta.dev', 'title' => 'My wiki', 'icon' => 'fa-solid fa-file-pen'])
          @include('partials.nav.icon', ['href' => 'https://github.com/JoaoCostaIFG', 'title' => 'My GitHub page', 'icon' => 'fa-brands fa-github'])
          @include('partials.nav.icon', ['href' => route('rss'), 'title' => "My blog's RSS", 'icon' => 'fa-solid fa-square-rss'])
        </div>
      </div>
    </nav>
  </header>

  <div id="content-container" class="container py-4 sm:rounded-b bg-background-100 text-foreground-800 dark:bg-background-800 dark:text-foreground-50">
    @yield('content')
  </div>
  <footer class="sticky top-[100vh] container p-0 mb-4">
    <hr class="border-1 w-full my-4 border-foreground-600 dark:border-foreground-500">
    <p class="text-sm muted">
      Copyright <a class="anchor" rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons</a> <i class="fa-solid fa-copyright"></i> 2019, 2020, 2021, 2022 <b>João Costa</b>
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
  @isset($js)
  @foreach ($js as $j)
  <script type="text/javascript" src="{{ $j }}"></script>
  @endforeach
  @endisset
  <?php
  ?>
</body>

</html>
