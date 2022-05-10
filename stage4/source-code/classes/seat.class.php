<?php 
/**
 * Seat class handles the queries executions to the database with data from the controller and view
 * @author Pedro Damian Marta Rubio https://github.com/damiansh
 * @copyright Copyright (c) 2022, Pedro Damian Marta Rubio 
 * @version 1.0
 */
class Seat extends PortalesDB{

    /**
     * updatePrice(): updates the prices of the given seats 
     *
     * @param object $seats object containing the seats to be updated 
     * @return void
     */      
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

    /**
     * updateReservation(): updates the a seat by the given id 
     * 
     * @param int $ticket id of the seat to be updated 
     * @param int $status the new status of the seat
     * @param string $reservedDate the new reserved date for the seat
     * @param int $userID the new user id for the seat
     * @param int $transactionID the new transaction id for the seat 
     * @return void
     */   
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

    /**
     * confirmAvailability(): confirms the availaibility of the given seats
     *
     * @param object $seats object containing the seats to be updated 
     * @return object $seats object updated 
     */     
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

    /**
     * getSeats(): gets seat information by play id 
     *
     * @param int $play_id the id of the play
     * @return object|null $seats object with the seats information 
     */       
     protected function getSeats($play_id){
        $query = 'SELECT * FROM seats WHERE play_id=? ORDER BY seat_number ASC;';
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
    
    /**
     * getCartContent(): gets the cart of the customer by its user id 
     *
     * @global int $_SESSION["userid"] the customer's user id 
     * @return object|null $seats object that contains the seats in the cart
     */     
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


    /**
     * confirmCart(): confirms the given seat by its id is still in the user's cart 
     *
     * @global int $_SESSION["userid"] the customer's user id 
     * @return boolean true|false 
     */          
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
    

    /**
     * startTransaction(): confirms the given seat by its id is still in the user's cart 
     *
     * @param float $orderTotal the total of the transaction 
     * @return int transaction[0]["transaction_id"], the id of the transaction 
     */     
    protected function startTransaction($orderTotal){
        date_default_timezone_set('America/Boise'); // change to MOUNTAIN TIME
        $currentDate = date('Y-m-d H:i:s'); //get currentDateTime
        $query = 'INSERT INTO transactions (transaction_date, user_id, order_total) VALUES (?,?,?);';
        $statement = $this->connect()->prepare($query);


        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($currentDate,$_SESSION["userid"],$orderTotal))){
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

    /**
     * confirmationEmail(): sends an confirmation email for the customer's purchase 
     *
     * @param int $transactionID the id of the current transaction 
     * @param float $total the total of the transaction 
     */         
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
    

    /**
     * emailBody(): generates the body of the email to be send 
     *
     * @param string $fname first name of the new customer 
     * @param string $lname last name of the new customer
     * @param int $transactionID id of the current transaction 
     * @param float $total for the current transaction 
     * @return void
     */     
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
