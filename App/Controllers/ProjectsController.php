<?php

namespace Controllers;

use Exception;
use Models\ProjModel;

class ProjectsController
{
  public static function show()
  {
    view('projs/index.php');
  }

  public static function showNewProjForm()
  {
    view('projs/new_proj.php');
  }

  public static function newProj()
  {
    // check for the required arguments
    if (!isset($_POST['title']) || !isset($_POST['url']) || !isset($_FILES['img'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('proj_insert_route'));
    }

    // check if image is ok
    $img_type = exif_imagetype($_FILES['img']['tmp_name']);
    if ($img_type === false || ($img_type !== IMAGETYPE_PNG && $img_type !== IMAGETYPE_JPEG && $img_type !== IMAGETYPE_GIF)) {
      // TODO set error
      // TODO recover info on error
      redirect(route('proj_insert_route'));
    }
    // img file name
    $img_name = preg_replace("/[^A-Za-z0-9\-]/", '', $_POST['title']);
    if (empty($img_name)) {
      // TODO set error
      // TODO recover info on error
      redirect(route('proj_insert_route'));
    }
    // get img extension
    switch ($img_type) {
      case IMAGETYPE_PNG:
        $img_ext = '.png';
        break;
      case IMAGETYPE_JPEG:
        $img_ext = '.jpg';
        break;
      case IMAGETYPE_GIF:
        $img_ext = '.gif';
        break;
      default:
        // unreachable
        break;
    }

    $args = array('title' => $_POST['title'], 'url' => $_POST['url'], 'img' => $img_name . $img_ext);

    if (isset($_POST['description']) && !empty($_POST['description'])) {
      $args['description'] = $_POST['description'];
    }

    try {
      $id = ProjModel::create($args);
      // save image after everything being ok
      move_uploaded_file(
        $_FILES['img']['tmp_name'],
        $_SERVER['DOCUMENT_ROOT'] . '/storage/img/projects/' . $img_name . $img_ext
      );
    } catch (Exception $e) {
      // TODO set error
      // TODO recover info on error
      echo '<pre>';
      print_r($_POST);
      print_r($_FILES);
      die();
      redirect(route('proj_insert_route'));
    }

    redirect(route('projects_route'));
  }
}
