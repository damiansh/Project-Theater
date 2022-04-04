<?php
/*$folderPath = '../../images/plays/';
$image_parts = explode(";base64,", $_POST['image']);
$image_base64 = base64_decode($image_parts[1]);
$file = $folderPath . uniqid() . '.png';
file_put_contents($file, "$image_base64");
echo json_encode(["image uploaded successfully."]);
*/

//Grabbing the data from the url
$image = $_POST['image'];
$folderPath = '../../images/plays/';
$name = uniqid();

//Instantiate auth classes 
include "../../classes/upload.class.php";
include "../../classes/upload-contr.class.php";
$upload = new UploadContr($image, $folderPath,$name);

//Running upload
$upload->sendImage();
 