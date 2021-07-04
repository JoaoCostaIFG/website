<?php

namespace Controllers;

use Exception;
use Models\UserModel;

class UserController
{
  public static function showLoginForm()
  {
    view('user/login_page.php');
  }

  public static function login()
  {
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
    unset($_SESSION['u']);
    redirect('home');
  }
}
