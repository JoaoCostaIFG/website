<?php

namespace App\Models;

use App\Database;
use Exception;

class UserModel
{
  private $id, $username, $password;

  public function __construct($username)
  {
    $db = Database::instance()->db();

    $stmt = $db->prepare('SELECT * FROM User WHERE user_username = ?');
    $stmt->execute(array($username));

    $blog = $stmt->fetch();
    if ($blog === false)
      throw new Exception("Failed to create User model.");

    $this->id = $blog['user_id'];
    $this->username = $blog['user_username'];
    $this->password = $blog['user_password'];
  }

  /**
   * @return User id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return User username
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * @return User password
   */
  public function getPassword()
  {
    return $this->password;
  }
}
