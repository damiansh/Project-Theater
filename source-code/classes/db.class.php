<?php 

class PortalesDB{
    protected function connect(){
       try {
          // LIVE
           $username = "epiz_31180792";
           $password = "FYngD3kvDx4c";
           $db = new PDO('mysql:host=sql200.epizy.com;dbname=epiz_31180792_losportales', $username, $password);
          /*
           //localhost
           $username = "root";
           $password = "";
           $db = new PDO('mysql:host=localhost;dbname=losportales', $username, $password);
           */
           return $db;

       } 
       catch (PDOException $e) {
           print "Error: " . $e->getMessage() . "<br/>";
           die();
       }
    }

}

