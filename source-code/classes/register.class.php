<?php 

class Register extends PortalesDB{

    protected function setUser($email,$psw,$fname,$lname,$birthday,$phone){
        $query = 'INSERT INTO customers (user_email, user_psw, user_fname, user_lname, user_birthday, user_phone, activation_code) VALUES (?,?,?,?,?,?,?);';
        $statement = $this->connect()->prepare($query);

        //hash password and activation code !IMPORTANT for security
        $hashedPsw = password_hash($psw, PASSWORD_DEFAULT);
        $code = bin2hex(random_bytes(16));
        $activation = password_hash($code,PASSWORD_DEFAULT);

        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($email, $hashedPsw, $fname, $lname, $birthday, $phone, $activation))){
            $statement = null;
            header("location: ../register.php?error=settingUser");
            exit();
        }
        //we send confirmation email 
        require 'sendEmail.php';
        require '../vendor/autoload.php';
        portalesEmail($email,"Los Portales Theatre Email Confirmation",$this->emailBody($code,$email,$fname,$lname));
        $statement = null;
    
    }
    
    protected function checkEmail($email){
        $query = 'SELECT user_email FROM customers WHERE user_email = ?;';
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

    protected function emailBody($activation,$email, $fname, $lname){
        $greeting = "Thank you <strong>{$fname} {$lname}</strong> for joining us on Los Portales Theatre!<br>";
        $hostname = getenv('HTTP_HOST');
        $link ="http://{$hostname}/auth/activate.php?email={$email}&code={$activation}";
        $link ="http://{$hostname}/losportales/auth/activate.php?email={$email}&code={$activation}"; //comment this when testing live
        $a = "<a href='{$link}' target='_blank'><strong>here</strong></a>";
        $body ="{$greeting}Please click {$a} to confirm your account.";
        return "<html>{$body}</html>";
    }
}