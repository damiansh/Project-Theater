<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
  <?php include 'scripts.php';
    if(isset($_SESSION["userid"])) 
      header("location: index.php");
  ?>
  
</head>
<body>

<?php include 'navbar.php';?>

  <div class="container">
    <form action="includes/included-register.php" method="post">
    <div class="container">
      <h1>Register</h1>
      <p>Please fill in this form to create an account.</p>
      <?php
        if(isset($_SESSION["message"])){
          echo "<p class='nMessage'>{$_SESSION["message"]}</p>";
          session_unset();
          session_destroy();
        }
      ?>
      <hr>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" id="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
      <hr>
      <button type="submit" name="register" class="registerbtn">Register</button>
    </div>
    
    <div class="container signin">
      <p>Already have an account? <a href="login.php">Sign in</a>.</p>
    </div>
  </form>

  </div>

</body>
</html>
