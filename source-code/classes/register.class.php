<?php 

class Register extends PortalesDB{

    protected function setUser($email,$psw){
        $query = 'INSERT INTO users (user_email, user_psw) VALUES (?,?);';
        $statement = $this->connect()->prepare($query);

        //hash password !IMPORTANT for security
        $hashedPsw = password_hash($psw, PASSWORD_DEFAULT);

        if(!$statement->execute(array($email, $hashedPsw))){
            $statement = null;
            header("location: ../register.php?error=settingUser");
            exit();
        }

        $statement = null;
    
    }
    
    protected function checkEmail($email){
        $query = 'SELECT user_email FROM users WHERE user_email = ?;';
        $statement = $this->connect()->prepare($query);

        if(!$statement->execute(array($email))){
            $statement = null;
            header("location: ../register.php?error=checkingEmail");
            exit();
        }
        $resultCheck;
        if($statement->rowCount() > 0){
            $resultCheck = false;
        }
        else{
            $resultCheck = true;
        }

        return $resultCheck;
    }
}