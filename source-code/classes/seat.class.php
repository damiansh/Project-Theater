<?php 

class Seat extends PortalesDB{

    //Method that retrieves user info based on email received 
    protected function updatePrice($seats){
        $query = 'UPDATE seats SET cost = ? WHERE ticket_id = ?;'; 
        $statement = $this->connect()->prepare($query);
        foreach ($seats as $seat){
            //to check if query was sucesfully run
            if(!$statement->execute(array($seat["cost"],$seat["ticket_id"]))){
                $statement = null;
                header("location: ../modifySeats.php?error=updateSeat&playID=" . urlencode($seat["play_id"]));
                exit();
            }
        }
        $statement = null;

    }
    //Method that updates seat owner, reserved date and status 
    protected function updateReservation($ticket,$status,$reservedDate, $userID, $transactionID){
        $query = 'UPDATE seats SET status = ?, reserved = ?, user_id = ?, transaction_id = ?  WHERE ticket_id = ?;'; 
        $statement = $this->connect()->prepare($query);
        //to check if query was sucesfully run
        if(!$statement->execute(array($status,$reservedDate,$userID,$transactionID, $ticket))){
            $statement = null;
            header("location: index.php?error=updateSeat");
            exit();
        }
        
        $statement = null;

    }

    //Method that updates the list of seats so it gets the latest status information before selectign seats or checking out
    protected function confirmAvailability($seats){
        $query = 'SELECT * FROM seats WHERE ticket_id = ?;'; 
        $statement = $this->connect()->prepare($query);
        foreach ($seats as &$seat){
            //to check if query was sucesfully run
            if(!$statement->execute(array($seat["ticket_id"]))){
                $statement = null;
                header("location: ../../selectSeats.php?error&playID=" . urlencode($seat["play_id"]));
                exit();
            }
            $current = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
            //echo $current[0]["status"];
            $seat["status"] = $current[0]["status"]; //we update the new status in the array
        }
        $statement = null;
        return $seats; //we return the seats array
    }  

     //Method that getSeats by play id 
     protected function getSeats($play_id){
        $query = 'SELECT * FROM seats WHERE play_id=?;';
        $statement = $this->connect()->prepare($query);
        
     
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($play_id))){
            $statement = null;
            header("location: ../index.php?error=loadingSeats");
            exit();
        }  


        //If there is not plays that meet the criteria
        if($statement->rowCount()==0){
            $statement = null;
            return "null";
        }

        $seats = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the seat data
        $statement = null;
        return $seats; //return the plays 

    }
    
    //Method that returns the number of items in the cart
    public function getCartContent(){
        $query = 'SELECT * FROM cart WHERE user_id = ?;'; 
        $statement = $this->connect()->prepare($query);

        //to check if query was sucesfully run
        if(!$statement->execute(array($_SESSION["userid"]))){
            $statement = null;
            return 0; 
        }
        $seats = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the cart data         
        return $seats;
    }  


     //Method that confirm if seat is still in the user's cart
     protected function confirmCart($ticket){
        $userID = $_SESSION["userid"]; 
        $query = 'SELECT * FROM seats WHERE user_id = ? AND ticket_id = ?;'; 
        $statement = $this->connect()->prepare($query);
        
     
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($userID, $ticket))){
            $statement = null;
            header("location: ../cart.php?error=removing");
            exit();
        }  


        //If there is not plays that meet the criteria
        if($statement->rowCount()==0){
            $statement = null;
            return false;
        }

        $statement = null;
        return true; 

    }
    
    //Method that stars a new transaction and returns the id 
    protected function startTransaction(){
        date_default_timezone_set('America/Boise'); // change to MOUNTAIN TIME
        $currentDate = date('Y-m-d H:i:s'); //get currentDateTime
        $query = 'INSERT INTO transactions (transaction_date, user_id) VALUES (?,?);';
        $statement = $this->connect()->prepare($query);


        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($currentDate,$_SESSION["userid"]))){
            $statement = null;
            header("location: ../cart.php?errorTransaction");
            exit();
        }
        $statement = null;

        $query = 'SELECT * FROM transactions WHERE user_id = ? ORDER BY transaction_id DESC LIMIT 1;';
        $statement = $this->connect()->prepare($query);

        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($_SESSION["userid"]))){
            $statement = null;
            header("location: ../cart.php?errorTransactionIDQ");
            exit();
        }
        
        //If there is not plays that meet the criteria
        if($statement->rowCount()==0){
            $statement = null;
            header("location: ../cart.php?errorTransactionID");
            exit();

        }
        $transaction = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the cart data         
        return  $transaction[0]["transaction_id"];

    }

     //confirmationEmail method to send email to user
     protected function confirmationEmail($transactionID,$total){
        //We retrieve the customer information
        $email = $_SESSION["userEmail"];
        $fname = $_SESSION["userFN"];
        $lname = $_SESSION["userLN"];
        //we send confirmation email 
        require 'sendEmail.php';
        require '../vendor/autoload.php';
        portalesEmail($email,"Transaction#{$transactionID} (\${$total})",$this->emailBody($fname,$lname,$transactionID,$total));
        $statement = null;
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


    //method to sent an email to confirm purchase 
    private function emailBody($fname, $lname, $transactionID,$total){
        $greeting = "<h2>Los Portales Theatre Order Confirmation #{$transactionID} for {$fname} {$lname}:</h2>";
        $greeting = "{$greeting}<p>Thank you for your purchase!</p>";
        $greeting = "{$greeting}<p><strong>Total charged to your card:</strong> \${$total}</p>";
        $hostname = getenv('HTTP_HOST');
        $link ="http://{$hostname}/tickets/printTickets.php?transactionID={$transactionID}";
        $link ="http://{$hostname}/losportales/tickets/printTickets.php?transactionID={$transactionID}"; //comment this when testing live
        $a = "<a href='{$link}' target='_blank'><strong>here</strong></a>";
        $body ="{$greeting}<p>Please click {$a} to print your tickets.</p>";
        return "<html>{$body}</html>";
    }
}
