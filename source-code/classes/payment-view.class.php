<?php 

class PaymentView extends Payment{
    private $paymentInfo; // seats associative array 
 
    public function __construct($userID){
       $this->paymentInfo = $this->requestPaymentInfo($userID);
    }

    //Method to generate Graphic Seat Plan 
    public function getPayInfo(){
        return $this->paymentInfo;  
    }


}