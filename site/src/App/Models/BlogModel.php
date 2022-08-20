<?php

namespace App\Models;

use App\Database;
use Exception;

/**
 * Average silent reading words per minute of an adult.
 * Source: https://thereadtime.com
 */
define("AVG_WPM", 238);

class BlogModel
{
  private $id, $date, $title, $intro, $content, $visible;

  public function __construct()
  {
  }

  public static function withID($id)
  {
    $instance = new self();
    $instance->loadByID($id);
    return $instance;
  }

  public static function withRow(array $row)
  {
    $instance = new self();
    $instance->fill($row);
    return $instance;
  }

  protected function loadByID($id)
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('SELECT * FROM Blog WHERE blog_id = ?');
    $stmt->execute(array($id));

    $row = $stmt->fetch();
    if ($row === false)
      throw new Exception("Failed to find Blog post with id: " . $id . ".");

    $this->fill($row);
  }

  protected function fill(array $row)
  {
    $this->id = $row['blog_id'];
    $this->date = $row['blog_date'];
    $this->title = $row['blog_title'];
    $this->intro = $row['blog_intro'];
    $this->content = $row['blog_content'];
    $this->visible = $row['blog_visible'];
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
  public function getDateStr()
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
   * @return number of words in intro + content
   */
  public function wordCount()
  {
    $cnt = str_word_count($this->content);
    if (!is_null($this->intro)) {
      $cnt += str_word_count($this->intro);
    }
    return $cnt;
  }

  /**
   * Returns the average silent reading time for the content.
   * Based on a paper by Marc Brysbaert (2019): https://www.sciencedirect.com/science/article/abs/pii/S0749596X19300786
   * @return the average reading time in minutes
   */
  public function readingTime() {
    return ceil($this->wordCount() / AVG_WPM);
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

  public static function update($b)
  {
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Blog SET blog_date=?, blog_title=?, blog_intro=?, blog_content=?, blog_visible=?
                          WHERE blog_id=?');
    $stmt->execute(array($b['date'], $b['title'], $b['intro'], $b['content'], $b['visible'], $b['id']));
  }

  /**
   * Fetch all blog posts in database sorted by date (descensing -> newest to oldest).
   */
  public static function all()
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('SELECT * FROM Blog ORDER BY blog_date DESC');
    $stmt->execute(array());

    $rows = $stmt->fetchAll();
    return array_map('App\Models\BlogModel::withRow', $rows);
  }

  public static function allVisible()
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('SELECT * FROM Blog
                          WHERE blog_visible = 1
                          ORDER BY blog_date DESC');
    $stmt->execute(array());

    $rows = $stmt->fetchAll();
    return array_map('App\Models\BlogModel::withRow', $rows);
  }

  public static function some($cnt)
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('SELECT * FROM Blog ORDER BY blog_date DESC LIMIT ?');
    $stmt->execute(array($cnt));

    $rows = $stmt->fetchAll();
    return array_map('App\Models\BlogModel::withRow', $rows);
  }

  public static function someVisible($cnt)
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('SELECT * FROM Blog
                          WHERE blog_visible = 1
                          ORDER BY blog_date DESC
                          LIMIT ?');
    $stmt->execute(array($cnt));

    $rows = $stmt->fetchAll();
    return array_map('App\Models\BlogModel::withRow', $rows);
  }
}
