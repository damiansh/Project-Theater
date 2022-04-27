<?php
if(isset($_POST["addP"]))
{

    //Grabbing the post data
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
    $playID = $play->addPlay();

    //Going to back 
    session_start();
    $_SESSION["message"] = "The play has been added sucessfully.";
    header("location: ../modifySeats.php?playID=" . urlencode($playID));

}
if(isset($_POST["publish"]))
{
    //grabbing post data
    $playID = $_POST["playID"];
    $published = $_POST["published"];

    //Instantiate auth classes 
    include "../../classes/db.class.php";
    include "../../classes/play.class.php";

    $play = new Play();

    //Running upload
    $play->publishPlay($playID,$published);
  
    //Going to back 
    session_start();
    $_SESSION["message"] = "The play has been published.";
    if($published == 0){
        $_SESSION["message"] = "The play has been unpublished and is not longer visible.";
    }
    header("location: ../modifySeats.php?playID=" . urlencode($playID));
}
