<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <?php include 'scripts.php';?>

</head>
<body>

<?php include 'navbar.php';?>

  <div class="container">
    <form action="includes/included-login.php" method="post">

    <div class="container">
      <?php
        if(isset($_SESSION["error"])){
          echo "<p class='loginError'>{$_SESSION["error"]}</p>";
          session_unset();
          session_destroy();
        }
      ?>
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
          
      <button type="submit" name="login">Login</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>

  </div>

 
</body>
</html>
