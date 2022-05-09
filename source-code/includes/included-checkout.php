
<?php
if(isset($_POST["deleteCart"])){

    //start session
    session_start();
    //Grabbing the data from the registration form
    $ticketN = $_POST["ticketN"];

    //Instantiate auth classes 
    include "../classes/db.class.php";
    include "../classes/seat.class.php";
    include "../classes/seat-contr.class.php";
    $cart = new SeatContr(null);  

    //Running error handlers remove cart
    $cart->removeFromCart($ticketN); 
 

    //Going to back to the cart
    $_SESSION["message"] = "The seat has been removed from the shopping cart";
    header("location: ../cart.php");
    
}
elseif(isset($_POST["checkout"])){
    //start session
    session_start();
    //Grabbing the data from the registration form
    $data = $_POST["cartData"];
    $cartSeats = json_decode($data,true);

    //Instantiate auth classes 
    include "../classes/db.class.php";
    include "../classes/seat.class.php";
    include "../classes/seat-contr.class.php";
    $cart = new SeatContr($cartSeats);
    $transactionID = $cart->prepareCheckOut();
    $transMSJ = "<h5>Transaction ID #{$transactionID}</h5>";
    $link = "tickets/printTickets.php?transactionID={$transactionID}";
    $printTickets = "<a href='{$link}' target='_blank'class='btn btn-secondary'>Print tickets</a>";
    //Going to back to the cart
    $_SESSION["message"] = "{$transMSJ}<p>Thank you for your purchase.<br>A confirmation e-mail has been sent to your email address.</p><p>Check your spam folder if you cannot find it.</p>{$printTickets}";
    header("location: ../cart.php");
}
else{
    header("location: ../index.php?error");
}