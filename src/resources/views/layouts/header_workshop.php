<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  $unique_title = 'Joao Costa';
  if ($args['title']) {
    $unique_title = $args['title'] . ' | ' . $unique_title;
  }
  ?>
  <title><?= $unique_title; ?></title>
  <link rel="stylesheet" type="text/css" href="<?= res_css('workshop.css'); ?>">
  <link rel="icon" href="/favicon.ico">
<body>
