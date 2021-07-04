<?php

namespace Models;

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/db.php';

use Database;
use Exception;

class BlogModel
{
  private $id, $date, $title, $intro, $content, $visible;

  public function __construct($id)
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('SELECT * FROM Blog WHERE blog_id = ?');
    $stmt->execute(array($id));

    $blog = $stmt->fetch();
    if ($blog === false)
      throw new Exception("Failed to create Blog post model.");

    $this->id = $blog['blog_id'];
    $this->date = $blog['blog_date'];
    $this->title = $blog['blog_title'];
    $this->intro = $blog['blog_intro'];
    $this->content = $blog['blog_content'];
    $this->visible = $blog['blog_visible'] === '1';
  }

  /**
   * @return Blog post id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return Blog post date (as integer)
   */
  public function getDateInt()
  {
    return $this->date;
  }

  /**
   * @return Blog post date (as string, yyyy-mm-dd)
   */
  public function getDateStr($param)
  {
    return gmdate("Y-m-d", $this->date);
  }
  

  /**
   * @return Blog post title
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * @return Blog post intro
   */
  public function getIntro()
  {
    return $this->intro;
  }

  /**
   * @return Blog post content
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * @return Whether blog post is publicly visible
   */
  public function isVisible()
  {
    return $this->visible;
  }

  /**
   * Arguments can be date, title, intro, content, and visible.
   * Only title and content are mandatory.
   * @return The id of the newly created blog instance
   */
  public static function create($b)
  {
    $db = Database::instance()->db();

    $querry = 'INSERT INTO Blog (';
    $querry_args = ') VALUES(';
    $args = array();
    if (isset($b['date'])) {
      $querry .= 'blog_date,';
      $querry_args .= '?,';
      array_push($args, $b['date']);
    }

    if (isset($b['title'])) {
      $querry .= 'blog_title,';
      $querry_args .= '?,';
      array_push($args, $b['title']);
    }

    if (isset($b['intro'])) {
      $querry .= 'blog_intro,';
      $querry_args .= '?,';
      array_push($args, $b['intro']);
    }

    if (isset($b['content'])) {
      $querry .= 'blog_content,';
      $querry_args .= '?,';
      array_push($args, $b['content']);
    }

    if (isset($b['visible'])) {
      $querry .= 'blog_visible,';
      $querry_args .= '?,';
      array_push($args, $b['visible']);
    }

    $querry = rtrim($querry, ',') . rtrim($querry_args, ',') . ')';

    $stmt = $db->prepare($querry);
    $stmt->execute($args);

    return $db->lastInsertId();
  }
}
