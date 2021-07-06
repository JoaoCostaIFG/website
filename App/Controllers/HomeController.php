<?php

namespace Controllers;

use Models\BlogModel;

class HomeController
{
  public static function show()
  {
    view_args('home.php', array('bs' => BlogModel::some(4)));
  }

  public static function redirect()
  {
    redirect('home');
  }
}
