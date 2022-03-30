<?php 

class Auth extends PortalesDB{

    //Method that retrieves user info based on email received 
    protected function getUser($email,$code){
        $query = 'SELECT * FROM customers WHERE user_email = ?;';
        $statement = $this->connect()->prepare($query);
        
        //to check if query was sucesfully run
        if(!$statement->execute(array($email))){
            $statement = null;
            header("location: ../login.php?error=getUserFailed");
            exit();
        }
        
        //Check if there was a match, if not, it means there is not such email in the database
        if($statement->rowCount()==0){
            $statement = null;
            session_start();
            $_SESSION["message"] = "Error: The e-mail you've tried to confirm doesn't exist.";
            header("location: ../register.php?loginError");
            exit();          
        }

        $user = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch al the user data based on email
        $checkCode = password_verify($code,$user[0]["activation_code"]); //check hashed pasword
        $active_status = $user[0]["active"];

        //If false the link used is false, if not, confirm account
        if($checkCode == false){
            $statement = null;
            session_start();
            $_SESSION["message"] = "Error: The link used is invalid.";
            header("location: ../register.php?loginError");
            exit();  
        }
        elseif($active_status ==1){
            $statement = null;
            echo "Your account is already activated.";
            exit(); 
        }
        elseif($checkCode==true){
            $query = 'UPDATE customers SET active = 1 WHERE user_email = ?;'; //confirming account
            $statement = $this->connect()->prepare($query);
            
            //to check if query was sucesfully run
            if(!$statement->execute(array($email))){
                $statement = null;
                header("location: ../register.php?error=confirmationFailed");
                exit();
            }
            $statement = null;
        }
    }

}