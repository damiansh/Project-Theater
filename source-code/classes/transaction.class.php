<?php 

class Transaction extends PortalesDB{

    //Method that gets user transaction and verifies it has the same user that request is
    protected function getTransaction($id){
        $userID = $_SESSION["userid"];
        $query = 'SELECT * FROM purchases WHERE transaction_id = ? and user_id = ?;';
        $statement = $this->connect()->prepare($query);
        
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($id, $userID))){
            $statement = null;
            header("location: index.php?error=errorTransaction");
            exit();
        }  

        //Check if rows
        if($statement->rowCount()==0){
            $statement = null;
            return null;         
        }

        $transactions = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $statement = null;
        return $transactions; 

    }

    //Method that gets transactions by play
    protected function getPlayTransactions($id){
        $query = 'SELECT * FROM purchases WHERE play_id = ? ORDER BY transaction_id ASC;';
        $statement = $this->connect()->prepare($query);
        
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($id))){
            $statement = null;
            header("location: index.php?error=errorPlayTransaction");
            exit();
        }  

        //Check if rows
        if($statement->rowCount()==0){
            $statement = null;
            return null;         
        }

        $transactions = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $statement = null;
        return $transactions; 

    }
    //Method that gets all transactions by user
    protected function getAllUTransaction(){
        $userID = $_SESSION["userid"];
        $query = 'SELECT * FROM transactions WHERE user_id = ? ORDER BY transaction_date DESC;';
        $statement = $this->connect()->prepare($query);
        
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($userID))){
            $statement = null;
            header("location: index.php?error=errorOrders");
            exit();
        }  

        //Check if rows
        if($statement->rowCount()==0){
            $statement = null;
            return null;         
        }

        $transactions = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $statement = null;
        return $transactions; 

    }

    //Method to calculate Seat Row and Col based on number
    protected function seatRowCol($number){
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
