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
  ?>
  <title>{{ $unique_title }}</title>
  <meta name="description" content="{{ $description }}">
  <meta name="author" content="João Costa">

  <!-- Mobile specific metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- OpenGraph
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta property="og:title" content="{{ $unique_title }}">
  <meta property="og:description" content="{{ $description }}">
  <meta property="og:image" content="{{ route('identicons', ['input' => urlencode($unique_title)]) }}">
  <meta property="og:locale" content="en_GB">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:site_name" content="Joao Costa">
  <meta name="twitter:card" content="summary">

  <!-- CSRF
  -------------------------------------------------- -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon and RSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" href="/favicon.ico">
  @include('feed::links')

  <!-- CSS + JS
  -------------------------------------------------- -->
  @isset($css)
    @vite($css)
  @endisset
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
  @vite(['resources/js/app.js'])
</head>

<body class="bg-background-200 dark:bg-background-900 min-h-screen">
  @include('partials.nav.bar')

  <div id="content-container"
    class="bg-background-100 text-foreground-800 dark:bg-background-800 dark:text-foreground-50 container py-4 sm:rounded-b">
    @yield('content')
  </div>

  @include('partials.nav.footer')
</body>

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
  @vite($js)
@endisset

</html>
