<?php 

class SeatContr extends Seat{
    private $seats; // seats associative array 
 
    public function __construct($seats){
       $this->seats = $seats;
    }

    public function setPrice(){
        $this->updatePrice($this->seats); 
    }


}