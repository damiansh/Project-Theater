<?php

if(isset($_POST["login"]) || isset($_POST["loginM"]))
{
    //Grabbing the data from the registration form
    $email = $_POST["email"];
    $psw = $_POST["psw"];
    $m = false; //if false customer login, if true management login
    if(isset($_POST["loginM"])){
        $m=true;
    }

    //Instantiate Register  Contr class
    include "../classes/db.class.php"; // needs to be loaded first
    include "../classes/login.class.php";
    include "../classes/login-contr.class.php";
    $login = new LoginContr($email,$psw,$m);

    //Running error handlers and user registration
    $login->loginUser();
    
    //Going to back to front page
    if($m){
        header("location: ../management"); //index page for management area
    }
    else{
        header("location: ../index.php?sucessfullyLogged"); //index page for customer area
    }

}