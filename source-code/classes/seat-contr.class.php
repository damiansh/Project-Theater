<?php 

class SeatContr extends Seat{
    private $seats; // seats associative array 
    
    //Seat Contr Constructor
    public function __construct($seats){
       $this->seats = $seats;
    }

    //function to set price of given seats
    public function setPrice(){
        $this->updatePrice($this->seats); 
    }


     //function to set price of given seats
    public function prepareCheckout(){
        $seats = $this->seats; 
        //error handler to confirm seat is still available 
        foreach ($seats as $seat){
            if(!$this->confirmCart($seat["ticket_id"])){
                $_SESSION["message"] = "The reservation of some seats has expired. Try clicking checkout again or add more seats if you wish to.";
                header("location: ../cart.php");
                exit();
            }        
        }
        $transactionID = $this->startTransaction(); //we start a new transaction
        $total = 0;
        foreach ($seats as $seat){
            $this->updateReservation($seat["ticket_id"],2,null,$_SESSION["userid"],$transactionID); //sets the status to purchased
            $total = $total + $seat["cost"];
        }
        $total = number_format($total,2);
        $this->confirmationEmail($transactionID,$total); //send confirmation email for the purchase 
        return $transactionID; //return transaction id 

    }

    //removes ticket from cart
    public function removeFromCart($ticket){
        if(!$this->confirmCart($ticket)){
            header("location: ../cart.php");
            exit();
        }
        $this->updateReservation($ticket,0,null,0,null);
    }


    //function that adds seats to the shopping cart
    //Shopping cart is where seats have an user id and its status are 1 
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