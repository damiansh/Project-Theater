<?php 

class RegisterContr extends Register{
    private $email;
    private $psw;
    private $pswRepeat;
    
    public function __construct($email,$psw,$pswRepeat){
        $this->email = $email;
        $this->psw = $psw;
        $this->pswRepeat = $pswRepeat;
    }

    public function registerUser(){
        if($this->missingInput()==true){
            //Missing some of the inputs
            session_start();
            $_SESSION["error"] = "Error: Fill in all the fields.";
            header("location: ../register.php?signupError");
            exit();
        }
        if($this->invalidEmail()==true){
            //Invalid email format
            session_start();
            $_SESSION["error"] = "Error: Invalid e-mail.";
            header("location: ../register.php?signupError");
            exit();
        }
        if($this->pswMatch()==false){
            //Passwords don't match
            session_start();
            $_SESSION["error"] = "Error: The passwords you've entered don't match.";
            header("location: ../register.php?signupError");
            exit();
        }
        if($this->emailUsed()==true){
            //Email already exists
            session_start();
            $_SESSION["error"] = "Error: This email is already in use.";
            header("location: ../register.php?signupError");
            exit();
        }
        $this->setUser($this->email,$this->psw);
    }

    //Error handlers for registration
    private function missingInput(){
        $result = false;
        if(empty($this->email) || empty($this->psw) || empty($this->pswRepeat)){
            $result = true;
        }
        return $result;
    }

    private function invalidEmail(){
        $result = false;
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $result = true;
        }
        return $result;
    }

    private function pswMatch(){
        $result = true;
        if($this->psw !== $this->pswRepeat){
            $result = false;
        }
        return $result;
    }

    private function emailUsed(){
        $result = false;
        if(!$this->checkEmail($this->email)){
            $result = true;
        }
        return $result;
    }
}