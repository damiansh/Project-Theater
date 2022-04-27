<?php 

class SeatContr extends Seat{
    private $seats; // seats associative array 
 
    public function __construct($play_id){
       $this->seats = $this->getSeats($play_id);
    }

    public function showSeats(){
        return $this->seats; 
    }


}