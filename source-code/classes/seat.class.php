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
    protected function updateReservation($seat,$status,$reservedDate, $userID){
        $query = 'UPDATE seats SET status = ?, reserved = ?, user_id = ? WHERE ticket_id = ?;'; 
        $statement = $this->connect()->prepare($query);
        //to check if query was sucesfully run
        if(!$statement->execute(array($status,$reservedDate,$userID, $seat["ticket_id"]))){
            $statement = null;
            header("location: index.php?error=updateSeat");
            exit();
        }
        
        $statement = null;

    }

    //Method that check availability of given seats and reeturns array with available and unavailable seats
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
}
