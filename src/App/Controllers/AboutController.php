<?php

namespace App\Controllers;

class AboutController
{
  public static function show()
  {
    view('about.php');
  }

  public static function cv()
  {
    view_args('download.php', array('filename' => 'files/joao_costa_resume.pdf'));
  }
}
