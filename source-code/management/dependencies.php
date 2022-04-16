<?php session_start();

 if (!isset($_SESSION["adminid"])){
    if(strpos($_SERVER['PHP_SELF'],"login") == false)
        header("location: login.php");
     }
?>

 <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css?version=<?php echo date("Y-m-d");?>">
    <link href="../css/cropper.min.css" rel="stylesheet">

<!-- javascript -->
    <script  type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
    <script  type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/cropper.min.js"></script>
    <script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>



<!-- MetaTAGS -->
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">