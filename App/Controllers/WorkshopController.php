<?php

namespace Controllers;

class WorkshopController
{
  public static function show()
  {
    view('workshops/index.php');
  }

  // TODO work on this part
  public static function showWorkshop($name)
  {
    switch ($name) {
      case 'shellscript':
        view_args('workshops/workshop.php', array('title' => 'Shellscript workshop', 'md' => '/resources/views/partials/workshops/workshop_shellscript.md'));
        break;
      case 'intropython3':
        view_args('workshops/workshop.php', array('title' => 'Intro to python3 workshop', 'md' => '/resources/views/partials/workshops/workshop_python3.md'));
        break;
      default:
        redirect('workshops_route');
        break;
    }
  }
}

