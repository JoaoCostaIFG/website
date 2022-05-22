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

function storage($path)
{
  return "/data/storage/" . $path;
}

function img($name)
{
  return storage("img/" . $name);
}

function layout($layout, $args)
{
  require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layouts/' . $layout;
}

/**
 * Will include the default layout header with the given arguments.
 * Note: args is used.
 *
 * @return void
 */
function layout_header_args($args)
{
  layout('header.php', $args);
}

/**
 * Will include the default layout header with the given page title.
 *
 * @return void
 */
function layout_header($title)
{
  layout_header_args(array('title' => $title));
}

/**
 * Will include the default layout footer with the given arguments.
 * Note: args is used.
 *
 * @return void
 */
function layout_footer_args($args)
{
  layout('footer.php', $args);
}

function layout_footer()
{
  layout_footer_args(array());
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
