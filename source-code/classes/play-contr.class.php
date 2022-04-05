<?php 

class PlayContr extends Play{
    private $playTitle;
    private $shortDesc;
    private $longDesc;
    private $sDate;
    private $eDate;
    private $image_base64;
    private $folderPath;
    
    public function __construct($playTitle, $shortDesc, $longDesc, $sDate, $eDate, $image, $folderPath){
        $this->playTitle = $playTitle;
        $this->shortDesc = $shortDesc;
        $this->longDesc = $longDesc;
        $this->sDate = $sDate;
        $this->eDate = $eDate;
        $image_parts = explode(";base64,", $image);
        $this->image_base64 = base64_decode($image_parts[1]);
        $this->folderPath = $folderPath;
    }

    public function addPlay(){
        //Error handling
        $this->insertPlay($this->playTitle, $this->shortDesc, $this->longDesc, $this->sDate, $this->eDate);
        $this->uploadImage($this->folderPath,$this->image_base64);
    }

    //Error handling methods
 


}