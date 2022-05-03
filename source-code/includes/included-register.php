<?php
session_start();
if(isset($_SESSION["userid"])){
    header("location: ../index.php?AlreadyRegistered");
}
elseif(isset($_POST["register"]))
{
    //Grabbing the data from the registration form
    $email = $_POST["email"];
    $psw = $_POST["psw"];
    $pswRepeat = $_POST["psw-repeat"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $birthday = $_POST["birthday"];
    $phone = $_POST["phone"];

    //Instantiate Register  Contr class
    include "../classes/db.class.php"; // needs to be loaded first
    include "../classes/register.class.php";
    include "../classes/register-contr.class.php";
    $register = new RegisterContr($email,$psw,$pswRepeat,$fname,$lname,$birthday,$phone);

    //Running error handlers and user registration
    $register->registerUser();
    
    //Going to back to registration page 
    session_start();
    $_SESSION["message"] = "A confirmation e-mail has been sent to your account.<br>Check your spam folder if you don't see the e-mail.";
    header("location: ../register.php?confirmedEmail");

}
else{
    header("location: ../index.php?error");
}