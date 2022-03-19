<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <?php include 'dependencies.php';
    if(isset($_SESSION["userid"])) 
      header("location: index.php");
  ?>
  
</head>
<body>

<?php include 'navbar.php';?>

  <div class="container">
    <form action="includes/included-login.php" method="post">
    <h1 class="eTitle display-3 text-center my-4">Login</h1>

    <div class="container">
      <?php
        if(isset($_SESSION["message"])){
          echo "<p class='nMessage'>{$_SESSION["message"]}</p>";
          session_unset();
          session_destroy();
        }
      ?>
      <div class="mb-3">
        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" class="form-control"name="email" required>
      </div>
      <div class="mb-3">
        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" class="form-control" name="psw" required>
      </div>
      <button type="submit" name="login" class="btn btn-secondary">Login</button>

    </div>

  </form>

  </div>

 
</body>
</html>
