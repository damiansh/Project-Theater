<?php 
/**
 * Login class handles the queries executions to the database with data from the controller and view
 * @author Pedro Damian Marta Rubio https://github.com/damiansh
 * @copyright Copyright (c) 2022, Pedro Damian Marta Rubio 
 * @version 1.0
 */
class Login extends PortalesDB{

    /**
     * getUser(): selects the users from the database by given email and if psw hash is true then logs the user
     *
     * @param string $email the email of the customer
     * @param string $psw customer password
     * @param boolean $m manager modal, if true then admin, else customer
     * @param string $destination, the destination if any error arises 
     * @return void
     */ 
    protected function getUser($email,$psw,$m,$destination){
        $query = 'SELECT * FROM customers WHERE user_email = ?;';
        if($m){
            $query = 'SELECT * FROM admin WHERE user_email = ?;';
        }
        $statement = $this->connect()->prepare($query);
        
        //to check if query was sucesfully run
        if(!$statement->execute(array($email))){
            $statement = null;
            header($destination."error=getUserFailed");
            exit();
        }
        
        //Check if there was a match, if not, it means there is not such email in the database
        if($statement->rowCount()==0){
            $statement = null;
            session_start();
            $_SESSION["message"] = "Error: The e-mail you’ve entered doesn't exist.";
            header($destination."loginError");
            exit();          
        }

        $user = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch al the user data based on email
        $checkPsw = password_verify($psw,$user[0]["user_psw"]); //check hashed pasword
        $active = $user[0]["active"];

        //If false the password is incorrect, otherwhise check if user is activated, if yes then log in
        if($checkPsw == false){
            $statement = null;
            session_start();
            $_SESSION["message"] = "Error: The password you’ve entered is incorrect.";
            header($destination."loginError");
            exit();  
        }
        elseif($checkPsw==true and $active==1){
            session_start();
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id(); //to prevent session fixation attacks
            if(!$m){
                $_SESSION["userEmail"] = $user[0]["user_email"];
                $_SESSION["userid"] = $user[0]["user_id"];
                $_SESSION["userFN"] = $user[0]["user_fname"];
                $_SESSION["userLN"] = $user[0]["user_lname"];               
            }
            else{
                $_SESSION["adminid"] = $user[0]["user_id"];
            }

            $statement = null;
        }
        else{
            $statement = null;
            session_start();
            $_SESSION["message"] = "Error: Your account hasn't been activated, check your e-mail.";
            header($destination."loginError");
            exit();              
        }
    }

}