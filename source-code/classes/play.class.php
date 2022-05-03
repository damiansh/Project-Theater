<?php 

class Play extends PortalesDB{

    //Method that adds play information to the table
    protected function insertPlay($playTitle, $shortDesc, $longDesc, $sDate, $eDate){
        $query = 'INSERT INTO plays (play_title, long_desc, short_desc, stime, etime) VALUES (?,?,?,?,?);';
        $statement = $this->connect()->prepare($query);


        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($playTitle, $longDesc, $shortDesc, $sDate, $eDate))){
            $statement = null;
            header("location: ../addPlay.php?error=errorAddPlay");
            exit();
        }
        $statement = null;
    }
    //Method that adds new seats per play 
    protected function addSeats($playID, $defaultCost){
        $query = 'INSERT INTO seats (play_id, seat_number, cost) VALUES (?,?,?);';
        $statement = $this->connect()->prepare($query);
        for($i=1;$i<=96;$i++){
            //this checks if the query is executed sucesfully 
            if(!$statement->execute(array($playID, $i, $defaultCost))){
                $statement = null;
                header("location: ../addPlay.php?error=errorAddSeat");
                exit();
            }
        }
        $statement = null;
    }

    //Method that updates Plays 
    protected function updatePlay($playID, $playTitle, $shortDesc, $longDesc, $sDate, $eDate){
        $query = 'UPDATE plays SET play_title=?, long_desc=?, short_desc=?, stime=?, etime=? WHERE play_id = ?;';
        $statement = $this->connect()->prepare($query);
        $uniqueURL = "{$playID}.png?" . uniqid();
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($playTitle, $longDesc, $shortDesc, $sDate, $eDate,$playID))){
            $statement = null;
            $_SESSION["message"] = "ERROR UPDATING PLAY #{$playID}.";
            header("location: ../index.php?error=updatePlay&playID=" . urlencode($playID));
            exit();
        }
        $statement = null;
    }    
    


    //Method that uploads the image and add URL to play
    protected function uploadImage($path,$base64,$playID,$page){
        $query = 'UPDATE plays SET pURL = ? WHERE play_id = ?;';
        $statement = $this->connect()->prepare($query);
        $uniqueURL = "{$playID}.png?" . uniqid();

        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($uniqueURL,$playID))){
            $statement = null;
            header("location: ../{$page}.php?error=errorAddImgURL");
            exit();
        }
        $imageName = $playID;
        $file = $path . $imageName . '.png';
        file_put_contents($file, "$base64");
        $statement = null;
        return $imageName; //return play ID 

    }

    //Method that gets latest play id
    protected function getPlayID(){
        $query = 'SELECT * FROM latestplay;';
        $statement = $this->connect()->prepare($query);
        
        
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array())){
            $statement = null;
            $_SESSION["message"] = "Error Querying.";
            header("location: ../index.php?error=errorgetPlay");
            exit();
        }  


        //Check if rows
        if($statement->rowCount()==0){
            $statement = null;
            $_SESSION["message"] = "NULL PLAYS";
            header("location: ../index.php?error=NullPlays");
            exit();          
        }

        $play = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $playID = $play[0]["play_id"];
        $statement = null;
        return $playID; //return play ID 

    }
    

     //Method that gets Upcoming and Published Plays
     protected function getUpcomingPlays(){
        date_default_timezone_set('America/Boise'); // change to MOUNTAIN TIME
        $currentDate = date('Y-m-d H:i:s'); //get currentDateTime
        $query = 'SELECT * FROM plays WHERE stime>=? AND published = ? ORDER BY stime ASC;';
        $statement = $this->connect()->prepare($query);
        
     
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($currentDate,1))){
            $statement = null;
            header("location: ../error=loadingPlays");
            exit();
        }  


        //If there is not plays that meet the criteria
        if($statement->rowCount()==0){
            $statement = null;
           return null;
        }

        $plays = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $statement = null;
        return $plays; //return the plays 

    }

     //Method that gets ALL PLAYS
     protected function getAllPlays(){
        $query = 'SELECT * FROM plays ORDER BY stime DESC;';
        $statement = $this->connect()->prepare($query);

     
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array())){
            $statement = null;
            header("location: ../index.php?error=loadingAllPlays");
            exit();
        }  


        //If there is not plays that meet the criteria
        if($statement->rowCount()==0){
            $statement = null;
           return null;
        }

        $plays = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $statement = null;
        return $plays; //return the plays 

    }


     //Method that gets an individual play 
     protected function getPlay($playID){
        $query = 'SELECT * FROM plays WHERE play_id=?;';
        $statement = $this->connect()->prepare($query);
        
     
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($playID))){
            $statement = null;
            header("location: ../index.php?error=loadingSinglePlay");
            exit();
        }  


        //If there is not plays that meet the criteria
        if($statement->rowCount()==0){
            $statement = null;
           return null;
        }

        $play = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $statement = null;
        return $play; //return the plays 

    }

    //Method that publishes the given play 
    public function publishPlay($playID,$published){
        $query = 'UPDATE plays SET published = ? WHERE play_id = ?;'; 
        $statement = $this->connect()->prepare($query);

        //to check if query was sucesfully run
        if(!$statement->execute(array($published,$playID))){
            $statement = null;
            $_SESSION["message"] = "ERROR PUBLISHING PLAY.";
            header("location: ../index.php?error=publishPlay&playID=" . urlencode($playID));
            exit();
        }
        
        $statement = null;

    }  

     //Method that publishes the given play 
     public function deletePlay($playID){
        //Seats contain foreign key for play, thus they must be deleted first
        $query = 'DELETE FROM seats WHERE play_id = ?; DELETE FROM plays WHERE play_id = ?;'; 
        $statement = $this->connect()->prepare($query);

        //to check if query was sucesfully run
        if(!$statement->execute(array($playID,$playID))){
            $statement = null;
            $_SESSION["message"] = "ERROR DELETING PLAY #{$playID}.";
            header("location: ../index.php?error=deletePlay&playID=" . urlencode($playID));
            exit();
        }
        
        $statement = null;

    }       

}
