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

function res_img($name)
{
  return res("static/img/" . $name);
}

function footer()
{
  require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/templates/layouts/tpl_footer.php';
}
