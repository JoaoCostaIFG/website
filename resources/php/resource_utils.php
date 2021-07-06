<?php

function res($name)
{
  return "/resources/" . $name;
}

function res_css($name)
{
  return res("css/" . $name);
}

function res_js($name)
{
  return res("js/" . $name);
}

function img($name)
{
  return "/storage/img/" . $name;
}

/**
 * Will include the layout header.
 * Note: title is used.
 *
 * @return void
 */
function layout_header($title)
{
  require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layouts/header.php';
}

function layout_footer()
{
  require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layouts/footer.php';
}

/**
 * Will include the target page file (to be used with files that include html).
 *
 * @return void
 */
function view_args($target, $args)
{
  require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/views/pages/' . $target;
}

function view($target)
{
  view_args($target, array());
}

/**
 * Will include the target partial file (to be used with files that include html).
 * This differs from the view function because it can include the target multiple
 * times.
 *
 * @return void
 */
function partial_args($target, $args)
{
  require $_SERVER['DOCUMENT_ROOT'] . '/resources/views/partials/' . $target;
}

function partial($target)
{
  partial_args($target, array());
}

/**
 * Will cause the client to redirected to the *target resource.
 * Needs to be the first and last output of a script.
 *
 * @return void
 */
function redirect($target)
{
  die(header('Location: ' . $target));
}
