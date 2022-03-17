<?php

if(isset($_GET['email']) and isset($_GET['code']))
{
    //Grabbing the data from the url
    $email = $_GET['email'];
    $hashedCode = $_GET['code'];
    echo $email . $hashedCode;

    //Instantiate auth classes 
    include "../classes/db.class.php"; // needs to be loaded first
    include "../classes/auth.class.php";
    include "../classes/auth-contr.class.php";
    $auth = new AuthContr($email,$hashedCode);
    //Running error handlers and user registration
    $auth->authUser();
     //Get the user to the login page so they can log-in
    session_start();
    $_SESSION["message"] = "You have sucesfully confirmed your account. You can log-in now.";
    header("location: ../login.php?emailConfirmed");

}
else{
    echo"Error, click the link you received in your e-mail.";
}








 
