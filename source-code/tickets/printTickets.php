<!DOCTYPE html>
<html>
<head>
  <title>Print Tickets</title>
  <?php include 'dependencies.php';?>

</head>
<?php 
include '../classes/db.class.php';
include '../classes/transaction.class.php';
include '../classes/transaction-view.class.php';
$transaction = new TransactionView();
if(!isset($_GET["transactionID"])){
    header("location: ../index.php?error");
}   
//Get transaction data
$transactionID = $_GET["transactionID"];
$transaction->requestTransaction($transactionID);
$transactionData = $transaction->getInfo();
//If transaction is null then thn it doesn't exist 
if($transactionData==null){
  header("location: index.php?NOFOUND");
}

?>
<body>

<div class="container">
<div class="d-grid gap-2 d-print-none">
  <button class="btn btn-secondary btn-lg" type="button" onclick="window.print()">Print tickets</button>
</div>
<?php $transaction->printTickets();?>
</div>

</body>

</html>
