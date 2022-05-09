<?php 

class PlayContr extends Play{
    private $playTitle;
    private $shortDesc;
    private $longDesc;
    private $sDate;
    private $eDate;
    private $cost;
    private $image_base64 =null;
    private $folderPath =null;

 
    public function __construct($playTitle, $shortDesc, $longDesc, $sDate, $eDate, $cost){
        $this->playTitle = $playTitle;
        $this->shortDesc = $shortDesc;
        $this->longDesc = $longDesc;
        $this->sDate = $sDate;
        $this->eDate = $eDate;
        $this->cost = $cost;
    }



    //method to prepare data to insert play 
    public function addPlay(){
        $this->errorHandlers("addPlay",null); //error handling
        $this->insertPlay($this->playTitle, $this->shortDesc, $this->longDesc, $this->sDate, $this->eDate);
        $playID = $this->getPlayID();
        $this->addSeats($playID, $this->cost);
        return $playID; 
    }
    //method to prepare changes to update play infomation
    public function prepareChanges($playID){
        $this->errorHandlers("index",$playID); //error handling
        $this->updatePlay($playID, $this->playTitle, $this->shortDesc, $this->longDesc, $this->sDate, $this->eDate);
    }

    //method to set image to be uploaded
    public function setImage($image, $folderPath,$playID,$page){
        $image_parts = explode(";base64,", $image);
        $this->image_base64 = base64_decode($image_parts[1]);
        $this->folderPath = $folderPath;
        $this->uploadImage($this->folderPath,$this->image_base64,$playID,$page);
    }
    //Missing Inputs
    private function missingInput(){
        $a = empty($this->playTitle);
        $b = empty($this->shortDesc);
        $c = empty($this->longDesc);
        $d = empty($this->sDate);
        $e = empty($this->eDate);
        $f = empty($this->cost);


        if($a || $b || $c || $d || $e || $f){
            return true; 
        }
        return false; 
    }

    //Check end date time is less than start date
    private function isEndDateLess(){
        $sDate = $this->sDate; 
        $eDate = $this->eDate; 
        if($eDate<=$sDate){
            return true; 
        }
        return false; 
    }

    //Check if dates are in different date 
    private function areDatesDifferent(){
        $sDate = $this->sDate; 
        $eDate = $this->eDate; 
        $sDate = date('m/d/Y',strtotime($sDate));
        $eDate = date('m/d/Y',strtotime($eDate));

        if($eDate!=$sDate){
            return true; 
        }
        return false; 
    }    

    //Title cannot be longer than 36 characters
    private function isTitleLonger(){
        $title = strlen($this->playTitle);
        if($title > 36){
            return true;
        }
        return false; 
     }

     
    //Short Description cannot be longer than 36 characters
    private function isShortLonger(){
       $shortDescL = strlen($this->shortDesc);
       if($shortDescL > 300){
           return true;
       }
       return false; 
    }

    private function errorHandlers($page,$playID){
        if($playID!=null){
            $playID = "playID={$playID}&";
        }
        //Error handling for missing input 
        if($this->missingInput()){
            $_SESSION["message"] = "Error: Fill in all the Play Information."; 
            header("location: ../{$page}.php?{$playID}MissingPlayInfo");
            exit();
        }
        //Error handling for End Date cannot be less than Start Date
        if($this->isEndDateLess()){
            $_SESSION["message"] = "Error: End Date and Time cannot be equal or less than Start Date."; 
            header("location: ../{$page}.php?{$playID}DateError");
            exit();
        }
        //Error handling for Different Dates
        if($this->areDatesDifferent()){
            $_SESSION["message"] = "Error: Start Date and End Date must be in the same day"; 
            header("location: ../{$page}.php?{$playID}DateError");
            exit();
        }   
        
        //Error handling short description higher than expected
        if($this->isShortLonger()){
            $sl = strlen($this->shortDesc); 
            $_SESSION["message"] = "Error: Your short description cannot be more than 300 characters. ({$sl})"; 
            header("location: ../{$page}.php?{$playID}DateError");
            exit();
        }  

        //Error handling title higher than expected
        if($this->isTitleLonger()){
            $sl = strlen($this->playTitle); 
            $_SESSION["message"] = "Error: Your play title cannot be more than 36 characters ({$sl})"; 
            header("location: ../{$page}.php?{$playID}DateError");
            exit();
        }                
    }


}