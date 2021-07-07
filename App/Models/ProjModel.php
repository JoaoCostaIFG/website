<?php

namespace Models;

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/db.php';

use Database;
use Exception;

class ProjModel
{
  private $id, $title, $description, $url, $img;

  public function __construct($id)
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('SELECT * FROM Proj WHERE proj_id = ?');
    $stmt->execute(array($id));

    $blog = $stmt->fetch();
    if ($blog === false)
      throw new Exception("Failed to Proj with id: " . $id . ".");

    $this->id = $blog['proj_id'];
    $this->title = $blog['proj_title'];
    $this->description = $blog['proj_description'];
    $this->url = $blog['proj_url'];
    $this->img = $blog['proj_img'];
  }

  /**
   * @return Project id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return Project title
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * @return Project description
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * @return Project URL
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * @return Project image path
   */
  public function getImg()
  {
    return $this->img;
  }

  /**
   * Arguments can be title, description, and url.
   * Only description is optional.
   * @return The id of the newly created proj instance
   */
  public static function create($p)
  {
    $db = Database::instance()->db();

    $querry = 'INSERT INTO Proj (';
    $querry_args = ') VALUES(';
    $args = array();

    if (isset($p['title'])) {
      $querry .= 'proj_title,';
      $querry_args .= '?,';
      array_push($args, $p['title']);
    }

    if (isset($p['description'])) {
      $querry .= 'proj_description,';
      $querry_args .= '?,';
      array_push($args, $p['description']);
    }

    if (isset($p['url'])) {
      $querry .= 'proj_url,';
      $querry_args .= '?,';
      array_push($args, $p['url']);
    }

    if (isset($p['img'])) {
      $querry .= 'proj_img,';
      $querry_args .= '?,';
      array_push($args, $p['img']);
    }

    $querry = rtrim($querry, ',') . rtrim($querry_args, ',') . ')';

    $stmt = $db->prepare($querry);
    $stmt->execute($args);

    return $db->lastInsertId();
  }
}

