<?php 

class Seat extends PortalesDB{

     //Method that getSeats by play id 
     protected function getSeats($play_id){
        $query = 'SELECT * FROM seats WHERE play_id=?;';
        $statement = $this->connect()->prepare($query);
        
     
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($play_id))){
            $statement = null;
            header("location: ../index.php?error=loadingPlays");
            exit();
        }  


        //If there is not plays that meet the criteria
        if($statement->rowCount()==0){
            $statement = null;
            return "null";
        }

        $seats = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $statement = null;
        return $seats; //return the plays 

    }

}