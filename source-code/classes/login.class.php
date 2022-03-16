<?php 

class Login extends PortalesDB{

    protected function getUser($email,$psw){
        $query = 'SELECT * FROM users WHERE user_email = ?;';
        $statement = $this->connect()->prepare($query);

        if(!$statement->execute(array($email))){
            $statement = null;
            header("location: ../login.php?error=getUserFailed");
            exit();
        }
        
        if($statement->rowCount()==0){
            $statement = null;
            session_start();
            $_SESSION["error"] = "Error: The e-mail you’ve entered doesn't exist.";
            header("location: ../login.php?loginError");
            exit();          
        }

        $user = $statement->fetchAll(PDO::FETCH_ASSOC);
        $checkPsw = password_verify($psw,$user[0]["user_psw"]);

        if($checkPsw == false){
            $statement = null;
            session_start();
            $_SESSION["error"] = "Error: The password you’ve entered is incorrect.";
            header("location: ../login.php?loginError");
            exit();  
        }
        elseif($checkPsw==true){
            session_start();
            session_regenerate_id(); //to prevent session fixation attacks
            $_SESSION["userid"] = $user[0]["user_id"];
            $_SESSION["userEmail"] = $user[0]["user_email"];
            $statement = null;
        }
    }

}