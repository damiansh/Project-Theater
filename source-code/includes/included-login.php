<?php

if(isset($_POST["login"]))
{
    //Grabbing the data from the registration form
    $email = $_POST["email"];
    $psw = $_POST["psw"];

    //Instantiate Register  Contr class
    include "../classes/db.class.php"; // needs to be loaded first
    include "../classes/login.class.php";
    include "../classes/login-contr.class.php";
    $login = new LoginContr($email,$psw);

    //Running error handlers and user registration
    $login->loginUser();
    
    //Going to back to front page
    header("location: ../index.php?sucessfullyLogged");

}