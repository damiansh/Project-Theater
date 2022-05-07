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
                $this->updateReservation($current,1,$currentDate,$_SESSION["userid"]); //reserves the seat for the user
                $seatTag = $this->seatRowCol($current['ticket_id']);
                $seatStatus["available"] = "{$seatStatus["available"]}{$seatTag}, ";
            }
            elseif($current["status"] == 1 || $current["status"] == 2){
                $seatTag = $this->seatRowCol($current['ticket_id']);
                $seatStatus["unavailable"] = "{$seatStatus["unavailable"]}{$seatTag}, ";
            }
        }
        return $seatStatus;
    }

    private function seatRowCol($number){
        if($number<=12){
            $seatN = $number-(12*0);
            return "A{$seatN}";
        }
        elseif($number<=24){
            $seatN = $number-(12*1);
            return "B{$seatN}";
        }
        elseif($number<=36){
            $seatN = $number-(12*2);
            return "C{$seatN}";
        }
        elseif($number<=48){
            $seatN = $number-(12*3);
            return "D{$seatN}";
        }
        elseif($number<=60){
            $seatN = $number-(12*4);
            return "E{$seatN}";
        }
        elseif($number<=72){
            $seatN = $number-(12*5);
            return "F{$seatN}";
        }
        elseif($number<=84){
            $seatN = $number-(12*6);
            return "G{$seatN}";
        }
        elseif($number<=96){
            $seatN = $number-(12*7);
            return "H{$seatN}";
        }

    }

}