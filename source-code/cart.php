<!DOCTYPE html>
<html>
<head>
  <title>Shopping cart</title>
  <?php include 'dependencies.php';?>
  <meta http-equiv="Refresh" content="60">

</head>


<body>

<?php include 'navbar.php';?>
<?php 

if(!isset($_SESSION["userid"])){
    header("location: login.php");
}  


?>
<div class="topImg" style="background-image:url('images/seats.jpg')">
    <div class="txt-overlay d-flex justify-content-center align-items-center">
      <h1 class="eTitle"><?php echo "{$_SESSION['userFN']}'s ";?>Cart</h1>
    </div>
</div>
<div class="container">
  <?php $cart->showCart();?>

</div>

<?php include "notification.php"?>
</body>

</html>

