<?php

namespace Controllers;

use Models\BlogModel;

class BlogController
{
  public static function showIndex()
  {
    view('blog/index.php');
  }

  public static function showPost($id)
  {
    view_args('blog/blog_post.php', array('b' => new BlogModel($id)));
  }
}

