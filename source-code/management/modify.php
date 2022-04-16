<!DOCTYPE html>
<html>
<head>
  <title>Management Area</title>
  <?php include 'dependencies.php';?>
</head>
<body>

<?php include 'navbar.php';?>
<div class="topImg" style="background-image:url('../images/modify-play.jpg')">
    <div class="txt-overlay d-flex justify-content-center align-items-center">
      <h1 class="eTitle">Modify Plays</h1>
    </div>
</div>
<div class="container">
  <?php 
    $l = "A";
    for ($i = 1; $i <= 8; $i++) {
      echo "<div class='row'><div class='btn-group' role='toolbar'>{$l}:";
      for ($j = 1; $j <= 12; $j++) {
        echo "<div ><input type='checkbox' class='btn-check' id='{$l}{$j}' autocomplete='off' onchange='testSeat(this)''>";
        echo "<label class='btn btn-outline-dark' for='{$l}{$j}'>{$j}</label></div>";
      }
      $l++;
      echo "</div></div>";
    }
  ?>

</div>

</body>

</html>
<script>
    function testSeat(seat){
      alert (seat.checked);
    }
  </script>