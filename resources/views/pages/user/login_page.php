<?php layout_header('Login'); ?>

<h2>Login</h2>

<form method="POST" action="<?php echo route('user_login_action'); ?>">
  <label for="username"><b>Username *</b></label>
  <input id="username" type="text" name="username" placeholder="Enter your username..." required autofocus><br>
  <label for="password"><b>Password *</b></label>
  <input id="password" type="password" name="password" placeholder="Enter password..." required><br>
  <input type="submit" value="Submit">
</form>

<?php layout_footer(); ?>
