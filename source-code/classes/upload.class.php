<?php 

class Upload{

    //Method that uploads the image
    protected function uploadImage($path,$base64,$name){
        $file = $path . $name . '.png';
        file_put_contents($file, "$base64");
        echo json_encode(["image uploaded successfully."]);
    }

}