<?php

namespace controllers;

class HomeController
{
  public static function show()
  {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/home.php';
  }
}
