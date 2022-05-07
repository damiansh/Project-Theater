<?php 

class Payment extends PortalesDB{

    //Method that retrieves user info based on email entered
    protected function requestPaymentInfo(){
        $userID = $_SESSION["userid"];
        $query = 'SELECT * FROM payment WHERE user_id = ?;';
        $statement = $this->connect()->prepare($query);
        
        //to check if query was sucesfully run
        if(!$statement->execute(array($userID))){
            $statement = null;
            header("location: index.php?error=paymentInfoError");
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
    protected function insertPaymentInfo($cnumber, $ctitular, $cmonth, $cyear, $ccvc, $cbilling, $czip){
        $userID = $_SESSION["userid"]; 
        $query = 'INSERT INTO payment (user_id,cnumber,ctitular,cmonth,cyear,ccvc,cbilling,czip) VALUES (?,?,?,?,?,?,?,?);';
        $statement = $this->connect()->prepare($query);
        
        //to check if query was sucesfully run
        if(!$statement->execute(array($userID,$cnumber, $ctitular, $cmonth, $cyear, $ccvc,$cbilling,$czip))){
            $statement = null;
            header("location: ../addPayment.php?error=AddingPayment");
            exit();
        }
   
        $statement = null;
    } 


    //Method that deletes the payment method of the logged user 
    public function deletePayment(){
    $userID = $_SESSION["userid"];
    $query = 'DELETE FROM payment WHERE user_id = ?;'; 
    $statement = $this->connect()->prepare($query);

    //to check if query was sucesfully run
    if(!$statement->execute(array($userID))){
        $statement = null;
        $_SESSION["message"] = "ERROR DELETING PAYMENT Method.";
        header("location: ../payment.php?error=deletePayment");
        exit();
    }
    
    $statement = null;

}        
}