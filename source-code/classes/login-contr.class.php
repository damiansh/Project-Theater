<?php 

class LoginContr extends Login{
    private $email;
    private $psw;
    
    public function __construct($email,$psw){
        $this->email = $email;
        $this->psw = $psw;
    }

    public function loginUser(){
        if($this->missingInput()==true){
            //Missing some of the inputs
            session_start();
            $_SESSION["message"] = "Error: Fill in all the fields.";
            header("location: ../login.php?loginError");
            exit();
        }

        $this->getUser($this->email,$this->psw);
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