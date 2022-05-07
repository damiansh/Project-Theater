<?php
$dateTime = new DateTime("2022-05-04 19:48:36");
$dateTime->modify('+10 minutes');
echo $dateTime->format('Y-m-d h:i') . "\n";

date_default_timezone_set('America/Boise'); // change to MOUNTAIN TIME
$currentDate = date('Y-m-d H:i:s'); //get currentDateTime
$currentDate = new DateTime('now');
echo $currentDate->format('Y-m-d h:i') . "\n";

if($currentDate>$dateTime){
    echo "late";
}
else{
    echo "not late";
}
