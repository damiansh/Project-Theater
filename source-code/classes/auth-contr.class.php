<?php 

class AuthContr extends Auth{
    private $email;
    private $code;
    
    public function __construct($email,$code){
        $this->email = $email;
        $this->code = $code;
    }

    public function authUser(){
        if($this->missingInput()==true){
            //Missing some of the inputs
            session_start();
            $_SESSION["message"] = "Error: Try clicking again in the confirmation email.";
            header("location: ../register.php?authError");
            exit();
        }

        $this->getUser($this->email,$this->code);
    }

    //Error handlers for auth
    private function missingInput(){
        $result = false;
        if(empty($this->email) || empty($this->code)){
            $result = true;
        }
        return $result;
    }


}