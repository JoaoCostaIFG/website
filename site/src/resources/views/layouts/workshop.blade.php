<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic page needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <?php
  $title = $name . ' | Joao Costa workshop';
  $description = 'Workshop slide deck by JoaoCostaIFG';
  ?>
  <title>{{ $title }}</title>
  <meta name="description" content="{{ $description }}">
  <meta name="author" content="João Costa">

  <!-- Mobile specific metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS + JS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  @vite(["resources/css/workshop.css"])

  <!-- OpenGraph
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta property="og:title" content="{{ $title }}">
  <meta property="og:description" content="{{ $description }}">
  <meta property="og:image" content="{{ route('identicons', ['input' => urlencode($title)]) }}">
  <meta property="og:locale" content="en_GB">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ Request::url() }}">
  <meta property="og:site_name" content="Joao Costa">
  <meta name="twitter:card" content="summary">

  <!-- Favicon and RSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" href="/favicon.ico">
  @include('feed::links')
</head>

<body class="bg-background-200 dark:bg-background-900 min-h-screen">
  @yield('content')
</body>

</html>
