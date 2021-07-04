<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php
  $unique_title = 'Joao Costa';
  $description = 'Hey! I&#39;m a computer engineering student and this is my personal website. I try to be active here.';
  if ($title) {
    $unique_title = $title . ' | ' . $unique_title;
  }
  ?>
  <title><?php echo $unique_title; ?></title>

  <link rel="stylesheet" type="text/css" href="<?php echo res_css('style.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo res_css('print.css'); ?>" media="print">

  <meta name="description" content="<?php echo $description; ?>">
  <meta property="og:title" content="<?php echo $unique_title; ?>">
  <meta property="og:description" content="<?php echo $description; ?>">
  <meta property="og:image" content="image.jpg">
  <meta property="og:locale" content="en_GB">
  <meta property="og:type" content="website">

  <meta property="og:url" content="<?php echo 'https://joaocosta.dev' . $_SERVER['SCRIPT_NAME']; ?>">
  <meta property="og:site_name" content="Joao Costa">
  <meta name="author" content="João Costa">
  <meta name="twitter:card" content="summary">

  <link rel="icon" href="/favicon.ico">
  <link rel="alternate" type="application/rss+xml" title="Posts - João Costa" href="https://joaocosta.dev/atom.xml">
</head>

<body>
  <header>
    <h1><a href="/">JoaoCostaIFG</a></h1>

    <ul id="menu">
      <li><a href="<?php echo route('about_route'); ?>">About me</a></li>
      <li><a href="<?php echo route('blog_index_route'); ?>">Blog Index</a></li>
      <li><a href="<?php echo route('contacts_route'); ?>">Contacts</a></li>
      <li>
        <a href="<?php echo route('projects_route'); ?>">Projects ></a>
        <ul class="menuDropdown">
          <li><a href="<?php echo route('projects_route'); ?>">Projects</a></li>
          <li><a href="/pages/workshops/">Workshops</a></li>
          <li><a href="https://wiki.joaocosta.dev">Wiki</a></li>
        </ul>
      </li>
      <li>
        <a href="https://gitlab.com/JoaoCostaIFG">
          <img src="<?php echo img('gitlab-icon.png'); ?>" alt="Gitlab">
        </a>
      </li>
      <li>
        <a href="https://github.com/JoaoCostaIFG">
          <img src="<?php echo img('github-icon.png'); ?>" alt="Github">
        </a>
      </li>
      <li>
        <a href="/atom.xml">
          <img src="<?php echo img('rss-icon.png'); ?>" alt="RSS">
        </a>
      </li>
      <?php if (is_auth()) { ?>
        <li><a href="<?php echo route('user_logout_route'); ?>">Logout</a></li>
      <?php } else { ?>
        <li><a href="<?php echo route('user_login_route'); ?>">Login</a></li>
      <?php } ?>
    </ul>
  </header>
