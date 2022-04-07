<?php
if(isset($_POST["addP"]))
{

    //Grabbing the data from the url
    $playTitle = $_POST['playTitle'];
    $shortDesc = $_POST['shortDesc'];
    $longDesc = $_POST['longDesc'];
    $sDate = $_POST['sDate'];
    $eDate = $_POST['eDate'];
    $image = $_POST['image'];
    $cost = $_POST['cost'];
    $folderPath = '../../images/plays/';

    //Instantiate auth classes 
    include "../../classes/db.class.php";
    include "../../classes/play.class.php";
    include "../../classes/play-contr.class.php";
    $play = new PlayContr($playTitle, $shortDesc, $longDesc, $sDate, $eDate, $cost, $image, $folderPath);

    //Running upload
    $play->addPlay();


    //Going to back 
    session_start();
    $_SESSION["message"] = "The play has been added sucessfully.";
    header("location: ../index.php?playAdded");

}
