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
    $this->visible = $blog['blog_visible'] === 1;
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

  public static function create($title, $intro, $content)
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('INSERT INTO Blog (blog_title, blog_intro, blog_content)
                        VALUES(?, ?, ?)');
    $stmt->execute(array($title, $intro, $content));

    return $db->lastInsertId();
  }
}
