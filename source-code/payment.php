<!DOCTYPE html>
<html>
<head>
  <title>Payment Information</title>
  <?php include 'dependencies.php';
        include 'classes/db.class.php';
        include 'classes/payment.class.php';
        include 'classes/payment-view.class.php';
  ?>
</head>
<body>
<?php include 'navbar.php';?>
<div class="topImg" style="background-image:url('images/welcome.jpg')">
    <div class="txt-overlay d-flex justify-content-center align-items-center">
      <h1 class="eTitle">Payment Method</h1>
    </div>
</div>
<div class="container">
 <?php
  $paymentInfo = new PaymentView($_SESSION["userid"]);
  $paymentInfo = $paymentInfo->getPayInfo();
  if($paymentInfo==null){
    header("location: addPayment.php");
  }
  $cnumber =  str_pad($paymentInfo[0]["cnumber"],16,"*",STR_PAD_LEFT);
  $ctitular = $paymentInfo[0]["ctitular"];
  $cmonth = $paymentInfo[0]["cmonth"];
  $cyear = $paymentInfo[0]["cyear"]; 
  $display = "{$ctitular} - {$cmonth}/20{$cyear}: {$cnumber}";
  ?>
<div class="container justify-content-center">
  <h1 class="league display-3 text-center my-4">Payment Method Information:</h1>
  <div class="row">
  <div class="d-grid col-10">
    <button class="btn btn-secondary btn-lg" type="button"><?php echo $display;?></button>
  </div>
  <div class="col-2">
        <button id ="deleteButton" type="button" class="btn btn-danger btn-lg" onClick="deleteImage()" >X</button>
  </div>
  </div>
</div>

<?php include "notification.php"?>
</body>

</html>
