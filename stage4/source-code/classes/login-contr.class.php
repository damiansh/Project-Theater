<?php 
/**
 * LoginContr is the controller class for the Login class. Handles and receives the login information
 * @author Pedro Damian Marta Rubio https://github.com/damiansh
 * @copyright Copyright (c) 2022, Pedro Damian Marta Rubio 
 * @version 1.0
 */
class LoginContr extends Login{
    private $email;
    private $psw;
    private $m;
    private $destination;

    /**
     * Initializes this class with the given options.
     *
     * @param string $email the email of the customer
     * @param string $psw code to confirm that confirmation of the email is valid 
     * @param boolean $m stands for manager mode, false=customer, true=admin 
     * @param string $destination for the error handlers (customer area or management area)
     */      
    public function __construct($email,$psw,$m){
        $this->email = $email;
        $this->psw = $psw;
        $this->m = $m;
        $this->destination = "location: ../login.php?";
        if($m){
            $this->destination = "location: ../management/login.php?";
        }
    }

    /**
     * loginUser(): executes error handling for login and then calls the database
     *
     * @return void
     */     
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

    /**
     * missingInput(): error handler that checks if input is missing 
     *
     * @return boolean true==error, false==OK
     */ 
    private function missingInput(){
        if(empty($this->email) || empty($this->psw)){
            return true;
        }
        return false;
    }


}