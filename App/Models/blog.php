<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/db.php';

function create($title, $intro, $content)
{
  $db = Database::instance()->db();

  $stmt = $db->prepare('INSERT INTO Blog (blog_title, blog_intro, blog_content)
                        VALUES(?, ?, ?)');
  $stmt->execute(array($title, $intro, $content));

  return $db->lastInsertId();
}
