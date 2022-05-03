<?php 

class PaymentView extends Payment{
    private $paymentInfo; // seats associative array 
 
    public function __construct(){
       $this->paymentInfo = $this->requestPaymentInfo();
    }

    //Method to generate Graphic Seat Plan 
    public function getPayInfo(){
        return $this->paymentInfo;  
    }


}