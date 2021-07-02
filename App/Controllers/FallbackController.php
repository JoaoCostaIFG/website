<?php

namespace Controllers;

class FallbackController
{
  public static function show()
  {
    view('404.php');
  }
}
