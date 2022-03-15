<?php

if(isset($_POST["register"]))
{
    //Grabbing the data from the registration form
    $email = $_POST["email"];
    $psw = $_POST["psw"];
    $pswRepeat = $_POST["psw-repeat"];

    //Instantiate Register  Contr class
    include "../classes/db.class.php"; // needs to be loaded first
    include "../classes/register.class.php";
    include "../classes/register-contr.class.php";
    $register = new RegisterContr($email,$psw,$pswRepeat);

    //Running error handlers and user registration
    $register->registerUser();
    
    //Going to back to front page
    header("location: ../index.php?sucessfullyRegistered");

}