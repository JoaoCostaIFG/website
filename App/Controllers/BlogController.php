<?php

namespace Controllers;

use Exception;
use Models\BlogModel;

class BlogController
{
  public static function showIndex()
  {
    view('blog/index.php');
  }

  public static function showPost($id)
  {
    try {
      $b = new BlogModel($id);
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
}
