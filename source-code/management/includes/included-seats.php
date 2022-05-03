<?php
session_start();
if(!isset($_SESSION["adminid"])){
    header("location: ../login.php?NotLogged");
}
elseif(isset($_POST["seatsJSON"]))
{


    $seatsJSON = $_POST["seatsJSON"];
    $seats = json_decode($seatsJSON,true);
    
    //Instantiate auth classes 
    include "../../classes/db.class.php";
    include "../../classes/seat.class.php";
    include "../../classes/seat-contr.class.php";
    $seatPlan = new SeatContr($seats);

    //Updating seats' cost 
    $seatPlan->setPrice();

    //Going to back 
    $_SESSION["message"] = "The prices have been updated.";
    header("location: ../modifySeats.php?playID=" . urlencode($seats[0]["play_id"]));

}
else{
    header("location: ../index.php?error");
}
