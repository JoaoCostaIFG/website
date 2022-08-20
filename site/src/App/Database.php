<?php

namespace App;

use PDO;
use Exception;

/**
 * Singleton class representating the database connection
 */
class Database
{
  private static $instance = NULL;
  private $db = NULL;

  /**
   * Private constructor. Creates db connection.
   */
  private function __construct()
  {
    $this->db = new PDO('sqlite:data/database/db.db');

    $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $this->db->query('PRAGMA foreign_keys=ON');
    // $this->db->query('PRAGMA journal_mode=WAL');

    if (NULL == $this->db)
      throw new Exception("Failed to open database.");
  }

  /**
   * @return database connection
   */
  public function db()
  {
    return $this->db;
  }

  /**
   * @return singleton instance (instantiated if needed)
   */
  static function instance()
  {
    if (self::$instance == NULL) {
      self::$instance = new Database();
    }

    return self::$instance;
  }
}
