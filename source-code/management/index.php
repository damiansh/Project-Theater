<!DOCTYPE html>
<html>
<head>
  <title>Management Area</title>
  <?php include 'dependencies.php';?>
</head>
<body>

<?php include 'navbar.php';?>
<div class="row text-white">
  <div class="thumbnail text-center">
    <img class="card-img-top darker" src="../images/welcome.jpg" alt="Play Name">
    <div class="caption">
      <h1 class="eTitle display-1 text-center">Los Portales Theatre</h1>
      <?php if (isset($_SESSION["adminid"])): ?>
        <!-- If logged in management area-->
        <h1 class="eTitle display-2 text-center">Welcome Admin!</h1>
         <!-- Redirect to login if not loggeed in -->
      <?php else:header("location: login.php");?>
      <?php endif; ?>
    </div>
  </div>
  </div>
  <?php include 'addPlay.php';?>


</body>

</html>
