<?php 

class Play extends PortalesDB{

    //Method that adds play information to the table
    protected function insertPlay($playTitle, $shortDesc, $longDesc, $sDate, $eDate){
        $query = 'INSERT INTO plays (play_title, long_desc, short_desc, stime, etime) VALUES (?,?,?,?,?);';
        $statement = $this->connect()->prepare($query);


        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($playTitle, $longDesc, $shortDesc, $sDate, $eDate))){
            $statement = null;
            header("location: ../index.php?error=errorAddPlay");
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
                header("location: ../index.php?error=errorAddSeat");
                exit();
            }
        }
        $statement = null;
    }


    //Method that uploads the image
    protected function uploadImage($path,$base64){
        $query = 'SELECT * FROM latestplay;';
        $statement = $this->connect()->prepare($query);
        
     
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array())){
            $statement = null;
            session_start();
            $_SESSION["message"] = "Error Querying.";
            header("location: ../index.php?error=errorUploadImage1");
            exit();
        }  


        //Check if rows
        if($statement->rowCount()==0){
            $statement = null;
            session_start();
            $_SESSION["message"] = "NULL PLAYS";
            header("location: ../index.php?error=errorUploadImage2");
            exit();          
        }

        $play = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $imageName = $play[0]["play_id"];
        $file = $path . $imageName . '.png';
        file_put_contents($file, "$base64");
        $statement = null;
        return $imageName; //return play ID 

    }


     //Method that Upcoming and Published Plays
     protected function getUpcomingPlays(){
        date_default_timezone_set('America/Boise'); // change to MOUNTAIN TIME
        $currentDate = date('Y-m-d H:i:s'); //get currentDateTime
        $query = 'SELECT * FROM plays WHERE stime>=? AND published = ? ORDER BY stime ASC;';
        $statement = $this->connect()->prepare($query);
        
     
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($currentDate,1))){
            $statement = null;
            header("location: ../index.php?error=loadingPlays");
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
            header("location: ../modifySeats.php?error=publishPlay&playID=" . urlencode($seat["play_id"]));
            exit();
        }
        
        $statement = null;

    }    

}
