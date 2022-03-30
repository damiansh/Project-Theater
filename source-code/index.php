<!DOCTYPE html>
<html>
<head>
  <title>Los Portales</title>
  <?php include 'dependencies.php';?>

</head>
<body>

<?php include 'navbar.php';?>
<div class="row text-white">
  <div class="thumbnail text-center">
    <img class="card-img-top darker" src="images/welcome.jpg" alt="Play Name">
    <div class="caption">
      <h1 class="eTitle display-1 text-center">Los Portales Theatre</h1>
      <?php if (isset($_SESSION["userid"])): ?>
        <h1 class="eTitle display-2 text-center">Welcome <?php echo $_SESSION["userFN"]; ?>!!</h1>
      <?php else: ?>
        <h1 class="eTitle display-2 text-center">Welcome Guest!!</h1>
      <?php endif; ?>
    </div>
  </div>
  </div>
<?php include 'upcoming.php';?>


</body>

</html>
