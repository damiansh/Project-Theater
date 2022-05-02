<?php 

class Payment extends PortalesDB{

    //Method that retrieves user info based on email entered
    protected function requestPaymentInfo($userID){
        $query = 'SELECT * FROM payment WHERE user_id = ?;';
        $statement = $this->connect()->prepare($query);
        
        //to check if query was sucesfully run
        if(!$statement->execute(array($userID))){
            $statement = null;
            header("location: payment.php?error=paymentInfoError");
            exit();
        }
        
        //Check if there was a match, if not, the payment method has not been added
        if($statement->rowCount()==0){
            $statement = null;
            return null;          
        }

        $paymentInfo = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the payment info
        $statement = null;
        return $paymentInfo; 
    }

    //Insert payment information
    protected function insertPaymentInfo($cnumber, $ctitular, $cmonth, $cyear, $ccvc){
        $userID = $_SESSION["userid"]; 
        $query = 'INSERT INTO payment (user_id,cnumber,ctitular,cmonth,cyear,ccvc) VALUES (?,?,?,?,?,?);';
        $statement = $this->connect()->prepare($query);
        
        //to check if query was sucesfully run
        if(!$statement->execute(array($userID,$cnumber, $ctitular, $cmonth, $cyear, $ccvc))){
            $statement = null;
            header("location: addPayment.php?error=AddingPayment");
            exit();
        }
   
        $statement = null;
    } 

    //Update payment information 
    protected function updatePaymentInfo($cnumber, $ctitular, $cmonth, $cyear, $ccvc){
        $userID = $_SESSION["userid"]; 
        $query = 'UPDATE plays SET cnumber=?, ctitular=?, cmonth=?, cyear=?, ccvc=? WHERE user_id = ?;';
        $statement = $this->connect()->prepare($query);
        
        //to check if query was sucesfully run
        if(!$statement->execute(array($cnumber, $ctitular, $cmonth, $cyear, $ccvc,$userID))){
            $statement = null;
            header("location: addPayment.php?error=AddingPayment");
            exit();
        }
   
        $statement = null;
    }      
}