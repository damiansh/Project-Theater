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
            header("location: ../index.php?error=missingInput". $this->email);
            exit();
        }
        if($this->invalidEmail()==true){
            //Invalid email format
            header("location: ../index.php?error=invalidEmail");
            exit();
        }
        if($this->pswMatch()==false){
            //Passwords don't match
            header("location: ../index.php?error=passwordsNotMatch");
            exit();
        }
        if($this->emailUsed()==true){
            //Email already exists
            header("location: ../index.php?error=emailAlreadyUsed");
            exit();
        }
        $this->setUser($this->email,$this->psw);
    }

    //Error handlers for registration
    private function missingInput(){
        $result = false;
        if(empty($this->email || $this->psw || $this->pswRepeat)){
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