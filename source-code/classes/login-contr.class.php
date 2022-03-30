<?php 

class LoginContr extends Login{
    private $email;
    private $psw;
    private $m;
    private $destination;
    
    public function __construct($email,$psw,$m){
        $this->email = $email;
        $this->psw = $psw;
        $this->m = $m;
        $this->destination = "location: ../login.php?";
        if($m){
            $this->destination = "location: ../management/login.php?";
        }
    }

    public function loginUser(){
        if($this->missingInput()==true){
            //Missing some of the inputs
            session_start();
            $_SESSION["message"] = "Error: Fill in all the fields.";
            header($this->destination ."loginError");
            exit();
        }

        $this->getUser($this->email,$this->psw,$this->m,$this->destination);
    }

    //Error handlers for log in
    private function missingInput(){
        $result = false;
        if(empty($this->email) || empty($this->psw)){
            $result = true;
        }
        return $result;
    }


}