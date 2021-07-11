<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php
  $unique_title = 'Joao Costa';
  $description = 'Hey! I&#39;m a computer engineering student and this is my personal website. I try to be active here.';
  if ($args['title']) {
    $unique_title = $args['title'] . ' | ' . $unique_title;
  }
  ?>
  <title><?= $unique_title; ?></title>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?= res_css('style.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= res_css('print.css'); ?>" media="print">
  <?php
  if (isset($args['css'])) {
    foreach ($args['css'] as $css) { ?>
      <link rel="stylesheet" type="text/css" href="<?= res_css($css); ?>">
  <?php }
  } ?>

  <!-- OpenGraph -->
  <meta name="description" content="<?= $description; ?>">
  <meta property="og:title" content="<?= $unique_title; ?>">
  <meta property="og:description" content="<?= $description; ?>">
  <meta property="og:image" content="image.jpg">
  <meta property="og:locale" content="en_GB">
  <meta property="og:type" content="website">

  <meta property="og:url" content="<?= 'https://joaocosta.dev' . $_SERVER['SCRIPT_NAME']; ?>">
  <meta property="og:site_name" content="Joao Costa">
  <meta name="author" content="João Costa">
  <meta name="twitter:card" content="summary">

  <link rel="icon" href="/favicon.ico">
  <link rel="alternate" type="application/rss+xml" title="Posts - João Costa" href="<?= route('projects_route'); ?>">

  <meta name="csrf-token" content="<?= $_SESSION['csrf']; ?>">
</head>

<body>
  <header>
    <h1><a href="<?= route('home_route'); ?>">JoaoCostaIFG</a></h1>

    <ul id="menu">
      <li><a href="<?= route('about_route'); ?>">About me</a></li>
      <li><a href="<?= route('blog_index_route'); ?>">Blog Index</a></li>
      <li><a href="<?= route('contacts_route'); ?>">Contacts</a></li>
      <li>
        <a href="<?= route('projects_route'); ?>">Projects ></a>
        <ul class="menuDropdown">
          <li><a href="<?= route('projects_route'); ?>">Projects</a></li>
          <li><a href="<?= route('workshops_route'); ?>">Workshops</a></li>
          <li><a href="https://wiki.joaocosta.dev">Wiki</a></li>
        </ul>
      </li>
      <li>
        <a href="https://gitlab.com/JoaoCostaIFG">
          <img src="<?= img('gitlab-icon.png'); ?>" alt="Gitlab">
        </a>
      </li>
      <li>
        <a href="https://github.com/JoaoCostaIFG">
          <img src="<?= img('github-icon.png'); ?>" alt="Github">
        </a>
      </li>
      <li>
        <a href="<?= route('rss_route'); ?>">
          <img src="<?= img('rss-icon.png'); ?>" alt="RSS">
        </a>
      </li>
      <?php if (is_auth()) { ?>
        <li><a href="<?= route('user_logout_route'); ?>">Logout</a></li>
      <?php } else { ?>
        <li><a href="<?= route('user_login_route'); ?>">Login</a></li>
      <?php } ?>
    </ul>
  </header>
