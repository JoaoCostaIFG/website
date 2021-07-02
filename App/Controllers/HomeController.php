<?php

namespace Controllers;

class HomeController
{
  public static function show()
  {
    view('home.php');
  }

  public static function redirect()
  {
    redirect('home');
  }
}
