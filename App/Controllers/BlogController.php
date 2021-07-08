<?php

namespace Controllers;

use Exception;
use Models\BlogModel;

class BlogController
{
  public static function showIndex()
  {
    view_args('blog/index.php', array('bs' => (is_auth()) ? BlogModel::all() : BlogModel::allVisible()));
  }

  public static function showPost($id)
  {
    try {
      $b = BlogModel::withID($id);
    } catch (Exception $e) {
      // blog post doesn't exist
      redirect(route('blog_index_route'));
    }

    // check if user has permission to read hidden posts
    if (!$b->isVisible() && !is_auth()) {
      redirect(route('blog_index_route'));
    }

    view_args('blog/blog_post.php', array('b' => $b));
  }

  public static function showNewPostForm()
  {
    view('blog/new_blog_post.php');
  }

  public static function newPost()
  {
    // csrf
    if (!isset($_POST['csrf']) || ($_SESSION['csrf'] !== $_POST['csrf'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('proj_insert_route'));
    }

    // check for the required arguments
    if (!isset($_POST['title']) || !isset($_POST['content'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('blog_insert_route'));
    }

    $args = array('title' => $_POST['title'], 'content' => $_POST['content']);

    if (isset($_POST['intro']) && !empty($_POST['intro'])) {
      $args['intro'] = $_POST['intro'];
    }

    if (isset($_POST['date']) && !empty($_POST['date'])) {
      $args['date'] = strtotime($_POST['date']);
      if ($args['date'] === false) {
        // TODO set error
        // TODO recover info on error
        redirect(route('blog_insert_route'));
      }
    }

    if (isset($_POST['visibility'])) {
      $args['visibility'] = ($_POST['visibility'] === 'on') ? 1 : 0;
    }

    try {
      $id = BlogModel::create($args);
    } catch (Exception $e) {
      // TODO set error
      // TODO recover info on error
      redirect(route('blog_insert_route'));
    }

    redirect(route_args('blog_post_route', array('id' => $id)));
  }

  public static function showEditPostForm($id)
  {
    try {
      $b = BlogModel::withID($id);
    } catch (Exception $e) {
      // blog post doesn't exist
      redirect(route('blog_index_route'));
    }

    // check if user has permission edit posts
    if (!is_auth()) {
      redirect(route('blog_index_route'));
    }

    view_args('blog/edit_blog_post.php', array('b' => $b));
  }

  public static function editPost()
  {
    // csrf
    if (!isset($_POST['csrf']) || ($_SESSION['csrf'] !== $_POST['csrf'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('proj_insert_route'));
    }

    // check for the required arguments
    if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['content'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('blog_edit_route'), array('id' => $_POST['id']));
    }

    $args = array('id' => $_POST['id'], 'title' => $_POST['title'], 'content' => $_POST['content']);

    if (isset($_POST['intro']) && !empty($_POST['intro'])) {
      $args['intro'] = $_POST['intro'];
    } else {
      $args['intro'] = NULL;
    }

    if (isset($_POST['date']) && !empty($_POST['date'])) {
      $args['date'] = strtotime($_POST['date']);
      if ($args['date'] === false) {
        // TODO set error
        // TODO recover info on error
        redirect(route('blog_edit_route'), array('id' => $_POST['id']));
      }
    } else { // no fallback date? (maybe use today)
      // TODO set error
      // TODO recover info on error
      redirect(route('blog_edit_route'), array('id' => $_POST['id']));
    }

    if (isset($_POST['visibility'])) {
      $args['visible'] = ($_POST['visibility'] === 'on') ? 1 : 0;
    } else {
      $args['visible'] = 0;
    }

    try {
      BlogModel::update($args);
    } catch (Exception $e) {
      // TODO set error
      // TODO recover info on error
      redirect(route_args('blog_edit_route', array('id' => $_POST['id'])));
    }

    redirect(route_args('blog_post_route', array('id' => $_POST['id'])));
  }
}
