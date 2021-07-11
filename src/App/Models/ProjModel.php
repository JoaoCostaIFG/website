<?php

namespace App\Models;

use App\Database;
use Exception;

class ProjModel
{
  private $id, $title, $description, $url, $img;

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

    $stmt = $db->prepare('SELECT * FROM Proj WHERE proj_id = ?');
    $stmt->execute(array($id));

    $row = $stmt->fetch();
    if ($row === false)
      throw new Exception("Failed to Proj with id: " . $id . ".");

    $this->fill($row);
  }

  protected function fill(array $row)
  {
    $this->id = $row['proj_id'];
    $this->title = $row['proj_title'];
    $this->description = $row['proj_description'];
    $this->url = $row['proj_url'];
    $this->img = $row['proj_img'];
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

  /*
   * Update a project entry.
   */
  public static function update($p)
  {
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Proj SET proj_title=?, proj_description=?, proj_url=?, proj_img=?
                          WHERE proj_id=?');
    $stmt->execute(array($p['title'], $p['description'], $p['url'], $p['img'], $p['id']));
  }

  /**
   * Fetch all projects in database
   */
  public static function all()
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('SELECT * FROM Proj');
    $stmt->execute(array());

    $rows = $stmt->fetchAll();
    return array_map('App\Models\ProjModel::withRow', $rows);
  }
}
