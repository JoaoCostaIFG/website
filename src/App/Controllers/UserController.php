<?php

namespace App\Controllers;

use Exception;
use App\Models\UserModel;

class UserController
{
  public static function showLoginForm()
  {
    view('user/login_page.php');
  }

  public static function login()
  {
    // csrf
    if (!isset($_POST['csrf']) || ($_SESSION['csrf'] !== $_POST['csrf'])) {
      // TODO set error
      // TODO recover info on error
      redirect(route('proj_insert_route'));
    }

    if (!isset($_POST['username']) || !isset($_POST['password'])) {
      // TODO set error
      redirect('login');
    }

    try {
      $u = new UserModel($_POST['username']);
    } catch (Exception $e) {
      // TODO set error
      redirect('login');
    }

    if (!password_verify($_POST['password'], $u->getPassword())) {
      // TODO set error
      redirect('login');
    }

    // congrats you logged in
    $_SESSION['u'] = $u;
    redirect('home');
  }

  public static function logout()
  {
    $_SESSION = array(); // to destroy session data, no session_destroy() is needed
    redirect('home');
  }
}
