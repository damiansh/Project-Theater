<?php 

class UploadContr extends Upload{
    private $folderPath;
    private $image_base64;
    private $name;
    
    public function __construct($image, $folderPath, $name){
        $this->folderPath = $folderPath;
        $image_parts = explode(";base64,", $image);
        $this->image_base64 = base64_decode($image_parts[1]);
        $this->name = $name;
    }

    public function sendImage(){
        //Error handling
        $this->uploadImage($this->folderPath,$this->image_base64,$this->name);
    }

    //Error handling methods
 


}