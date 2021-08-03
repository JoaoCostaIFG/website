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
  <link rel="stylesheet" type="text/css" href="<?= res_css('normalize.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= res_css('skeleton.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= res_css('custom.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= res_css('print.css'); ?>" media="print">
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
  <meta property="og:image" content="image.jpg">
  <meta property="og:locale" content="en_GB">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= 'https://joaocosta.dev' . $_SERVER['SCRIPT_NAME']; ?>">
  <meta property="og:site_name" content="Joao Costa">
  <meta name="twitter:card" content="summary">

  <!-- Favicon and RSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" href="/favicon.ico">
  <link rel="alternate" type="application/rss+xml" title="Posts - João Costa" href="<?= route('projects_route'); ?>">

  <meta name="csrf-token" content="<?= $_SESSION['csrf']; ?>">
</head>

<body>
  <header class="container">

    <nav arial-label="primary navigation">
      <ul class="menu">
        <li class="menu-item">
          <h1 id="brand"><a href="<?= route('home_route'); ?>">JoaoCostaIFG</a></h1>
        </li>
        <li class="menu-item"><a href="<?= route('about_route'); ?>">About me</a></li>
        <li class="menu-item"><a href="<?= route('blog_index_route'); ?>">Blog Index</a></li>
        <li class="menu-item"><a href="<?= route('contacts_route'); ?>">Contacts</a></li>
        <!--
            <li class="menu-item">
              <a href="<?= route('projects_route'); ?>">Projects ></a>
              <ul class="menuDropdown">
                <li><a href="<?= route('projects_route'); ?>">Projects</a></li>
                <li><a href="<?= route('workshops_route'); ?>">Workshops</a></li>
                <li><a href="https://wiki.joaocosta.dev">Wiki</a></li>
              </ul>
            </li>
        -->
      </ul>
      <ul class="menu menu-right">
        <li class="menu-item">
          <a href="https://gitlab.com/JoaoCostaIFG"><img src="<?= img('gitlab-icon.png'); ?>" alt="Gitlab"></a>
        </li>
        <li class="menu-item">
          <a href="https://github.com/JoaoCostaIFG"><img src="<?= img('github-icon.png'); ?>" alt="Github"></a>
        </li>
        <li class="menu-item">
          <a href="<?= route('rss_route'); ?>"><img src="<?= img('rss-icon.png'); ?>" alt="RSS"></a>
        </li>
        <?php if (is_auth()) { ?>
          <li class="menu-item"><a href="<?= route('user_logout_route'); ?>">Logout</a></li>
        <?php } else { ?>
          <li class="menu-item"><a href="<?= route('user_login_route'); ?>">Login</a></li>
        <?php } ?>
      </ul>
    </nav>
    <hr id="menu-line">
  </header>

  <div id="main-container" class="container">
