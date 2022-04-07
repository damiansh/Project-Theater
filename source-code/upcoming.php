<?php
   //Instantiate auth classes 
   include "classes/db.class.php";
   include "classes/play.class.php";
   include "classes/play-view.class.php";

   $play = new PlayView();
  
?>

<div class="container">
    <h1 class="eTitle display-3 text-center my-4">Upcoming Shows</h1>
    <div class="row">
        <?php $play->printPlays(); ?>
        
    </div>
</div>
