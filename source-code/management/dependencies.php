<?php 
session_start();
if(isset($_SESSION["userid"])){
    session_unset();
    session_destroy();
}
?>
 <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css">

<!-- javascript -->
    <script  type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
    <script  type="text/javascript" src="../js/main.js"></script>


<!-- MetaTAGS -->
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">