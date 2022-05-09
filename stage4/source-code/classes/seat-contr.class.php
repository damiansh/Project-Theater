<?php 
/**
 * SeatContr is the controller class for the Seat class. Handles and receives the seat information
 * @author Pedro Damian Marta Rubio https://github.com/damiansh
 * @copyright Copyright (c) 2022, Pedro Damian Marta Rubio 
 * @version 1.0
 */
class SeatContr extends Seat{
    private $seats; 
    
    /**
     * Initializes this class with the given options.
     *
     * @param object $seats object with the seat information 
     */      
    public function __construct($seats){
       $this->seats = $seats;
    }

    /**
     * setPrice(): sends the seat data to the Seat Class to update the price of the seats in the object
     *
     * @return void
     */     
    public function setPrice(){
        $this->updatePrice($this->seats); 
    }


    /**
     * prepareCheckout(): prepares the checkout for the seats in the object 
     *
     * @param float $orderTotal total of the cart with tax 
     * @return int $transactionID it returns the new transaction id generated for the purchase 
     */       
    public function prepareCheckout($orderTotal){
        $seats = $this->seats; 
        //error handler to confirm seat is still available 
        foreach ($seats as $seat){
            if(!$this->confirmCart($seat["ticket_id"])){
                $_SESSION["message"] = "The reservation of some seats has expired. Try clicking checkout again or add more seats if you wish to.";
                header("location: ../cart.php");
                exit();
            }        
        }
        $transactionID = $this->startTransaction($orderTotal); //we start a new transaction
        foreach ($seats as $seat){
            $this->updateReservation($seat["ticket_id"],2,null,$_SESSION["userid"],$transactionID); //sets the status to purchased
        }
        $this->confirmationEmail($transactionID,$orderTotal); //send confirmation email for the purchase 
        return $transactionID; //return transaction id 

    }

    /**
     * removeFromCart(): calls the method in the parent class to remove a ticket from the cart 
     *
     * @param int $ticket the id of the ticket to be removed 
     * @return void
     */       
    public function removeFromCart($ticket){
        if(!$this->confirmCart($ticket)){
            header("location: ../cart.php");
            exit();
        }
        $this->updateReservation($ticket,0,null,0,null);
    }



    /**
     * addtoCart(): executes methods to add seats to the shopping cart
     * Shopping cart is defined sd where seats have an user id and its status are 1 
     * @return object $seatStatus returns the available and unavailable seats
     */       
    public function addtoCart(){
        date_default_timezone_set('America/Boise'); // change to MOUNTAIN TIME
        $currentDate = date('Y-m-d H:i:s'); //get currentDateTime
        $selected = $this->confirmAvailability($this->seats); //checks availability and updates it 
        $counter = 0; 
        $seatStatus = new ArrayObject();
        $seatStatus["available"] = "";  //list of seats addeed to the shopping cart
        $seatStatus["unavailable"] = ""; // list of already reserved seats
        foreach ($selected as $current){
            if($current["status"] == 0){
                $this->updateReservation($current["ticket_id"],1,$currentDate,$_SESSION["userid"],null); //reserves the seat for the user
                $seatTag = $this->seatRowCol($current['seat_number']);
                $seatStatus["available"] = "{$seatStatus["available"]}{$seatTag}, ";
            }
            elseif($current["status"] == 1 || $current["status"] == 2){
                $seatTag = $this->seatRowCol($current['seat_number']);
                $seatStatus["unavailable"] = "{$seatStatus["unavailable"]}{$seatTag}, ";
            }
        }
        return $seatStatus;
    }

}