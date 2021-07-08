<?php

namespace Controllers;

use Exception;
use Models\ProjModel;

class ProjectsController
{
  public static function show()
  {
    view_args('projs/index.php', array('ps' => ProjModel::all()));
  }

  public static function showNewProjForm()
  {
    view('projs/new_proj.php');
  }

  /**
   * @return The image file name to be saved (comming from $_FILES).
   */
  private static function getImgFileName()
  {
    // check if image is ok
    $img_type = exif_imagetype($_FILES['img']['tmp_name']);
    if (
      $img_type === false ||
      ($img_type !== IMAGETYPE_PNG && $img_type !== IMAGETYPE_JPEG && $img_type !== IMAGETYPE_GIF && $img_type !== IMAGETYPE_WEBP)
    ) {
      return false;
    }

    // img file name
    $img_name = strtolower(preg_replace("/[^A-Za-z0-9\-_]/", '', $_POST['title']));
    if (empty($img_name)) {
      return false;
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
      case IMAGETYPE_WEBP:
        $img_ext = '.webp';
        break;
      default:
        // unreachable
        break;
    }

    return $img_name . $img_ext;
  }


  public static function newProj()
  {
    if (!is_auth()) redirect(route('blog_index_route'));

    // csrf
    if (!isset($_POST['csrf']) || ($_SESSION['csrf'] !== $_POST['csrf'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('proj_insert_route'));
    }

    // check for the required arguments
    if (!isset($_POST['title']) || !isset($_POST['url']) || !isset($_FILES['img']) || empty($_FILES['img']['tmp_name'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('proj_insert_route'));
    }

    $img = ProjectsController::getImgFileName();
    if ($img === false) {
      // TODO set error
      // TODO recover info on error
      redirect(route('proj_insert_route'));
    }
    $args = array('title' => $_POST['title'], 'url' => $_POST['url'], 'img' => $img);

    if (isset($_POST['description']) && !empty($_POST['description'])) {
      $args['description'] = $_POST['description'];
    }

    try {
      $id = ProjModel::create($args);
      // save image after everything being ok
      move_uploaded_file(
        $_FILES['img']['tmp_name'],
        $_SERVER['DOCUMENT_ROOT'] . img('projects/' . $img)
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

  public static function showEditProjForm($id)
  {
    // check if user has permission edit posts
    if (!is_auth()) {
      redirect(route('projects_route'));
    }

    try {
      $p = ProjModel::withID($id);
    } catch (Exception $e) {
      // blog post doesn't exist
      redirect(route('projects_route'));
    }

    view_args('projs/edit_proj.php', array('p' => $p));
  }

  public static function editProj()
  {
    if (!is_auth()) redirect(route('blog_index_route'));

    // csrf
    if (!isset($_POST['csrf']) || ($_SESSION['csrf'] !== $_POST['csrf'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('projects_route'));
    }

    // check for the required arguments
    if (!isset($_POST['id'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('projects_route'));
    }

    if (!isset($_POST['title']) || !isset($_POST['url']) || !isset($_POST['old_img'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route_args('proj_edit_route', array('id' => $_POST['id'])));
    }

    $args = array('id' => $_POST['id'], 'title' => $_POST['title'], 'url' => $_POST['url']);

    if (isset($_POST['description']) && !empty($_POST['description'])) {
      $args['description'] = $_POST['description'];
    } else {
      $args['description'] = NULL;
    }

    if (isset($_FILES['img']) && !empty($_FILES['img']['tmp_name'])) {
      $update_img = true;
      $img = ProjectsController::getImgFileName();
      if ($img === false) {
        // TODO set error
        // TODO recover info on error
        redirect(route_args('proj_edit_route', array('id' => $_POST['id'])));
      }
      $args['img'] = $img;
    } else {
      $update_img = false;
      $args['img'] = $_POST['old_img'];
    }

    try {
      ProjModel::update($args);
      if ($update_img) {
        // remove old fie
        unlink($_SERVER['DOCUMENT_ROOT'] . img('projects/' . $_POST['old_img']));
        // save image after everything being ok
        move_uploaded_file(
          $_FILES['img']['tmp_name'],
          $_SERVER['DOCUMENT_ROOT'] . img('projects/' . $img)
        );
      }
    } catch (Exception $e) {
      // TODO set error
      // TODO recover info on error
      redirect(route_args('proj_edit_route', array('id' => $_POST['id'])));
    }

    redirect(route('projects_route'));
  }
}
