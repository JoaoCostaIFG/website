<?php

namespace App\Controllers;

use App\Models\BlogModel;

class HomeController
{
  public static function show()
  {
    view_args('home.php', array('bs' => (is_auth()) ? BlogModel::some(4) : BlogModel::someVisible(4)));
  }

  public static function redirect()
  {
    redirect('/');
  }
}
