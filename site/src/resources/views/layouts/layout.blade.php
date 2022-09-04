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
  @vite(['resources/js/app.js'])
  @isset($js)
    @vite($js)
  @endisset
</head>

<body class="bg-background-200 dark:bg-background-900 min-h-screen">
  @include('partials.nav.bar')

  <div id="content-container"
    class="bg-background-100 text-foreground-800 dark:bg-background-800 dark:text-foreground-50 container py-4 sm:rounded-b">
    @yield('content')
  </div>

  @include('partials.nav.footer')
</body>

</html>
