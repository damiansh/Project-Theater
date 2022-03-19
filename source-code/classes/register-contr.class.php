<?php 

class RegisterContr extends Register{
    private $email;
    private $psw;
    private $pswRepeat;
    private $fname;
    private $lname;
    private $birthday;
    private $phone;
    
    public function __construct($email,$psw,$pswRepeat,$fname,$lname,$birthday,$phone){
        $this->email = $email;
        $this->psw = $psw;
        $this->pswRepeat = $pswRepeat;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->birthday = $birthday;
        $this->phone = $phone;

    }

    public function registerUser(){
        if($this->missingInput()==true){
            //Missing some of the inputs
            session_start();
            $_SESSION["message"] = "Error: Fill in all the fields.";
            header("location: ../register.php?signupError");
            exit();
        }
        if($this->invalidEmail()==true){
            //Invalid email format
            session_start();
            $_SESSION["message"] = "Error: Invalid e-mail.";
            header("location: ../register.php?signupError");
            exit();
        }
        if($this->pswMatch()==false){
            //Passwords don't match
            session_start();
            $_SESSION["message"] = "Error: The passwords you've entered don't match.";
            header("location: ../register.php?signupError");
            exit();
        }
        if($this->emailUsed()==true){
            //Email already exists
            session_start();
            $_SESSION["message"] = "Error: This email is already in use.";
            header("location: ../register.php?signupError");
            exit();
        }
        $this->setUser($this->email,$this->psw,$this->fname,$this->lname,$this->birthday,$this->phone);
    }

    //Error handlers for registration
    private function missingInput(){
        $result = false;
        $cEmail = empty($this->email);
        $cp = empty($this->psw);
        $cp2 = empty($this->pswRepeat);
        $cfn = empty($this->fname);
        $cln = empty($this->lname);
        $cBirthday = empty($this->birthday);
        $cPhone = empty($this->phone);

        if($cEmail || $cp || $cp2 || $cfn || $cln || $cBirthday || $cPhone){
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