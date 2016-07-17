<?php
require_once "src/connection.php";
require_once "src/user.php";
session_start();

if(isset($_SESSION['loggedUserId'])){
    header("Location: index.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = strlen(trim($_POST['email'])) > 0 ? trim($_POST['email']) : null;
    $password = strlen(trim($_POST['password'])) > 0 ? trim($_POST['password']) : null;
    $retypedPassword = strlen(trim($_POST['retypedPassword'])) > 0 ? trim($_POST['retypedPassword']) : null;
    $fullName = strlen(trim($_POST['fullName'])) > 0 ? trim($_POST['fullName']) : null;
    
    $user = User:: getUserByEmail($conn, $email);
    
    if($email && $password && $retypedPassword && $fullName && $password == $retypedPassword && !$user){
        $newUser = new User();
        $newUser->setEmail($email);
        $newUser->setPassword($password, $retypedPassword);
        $newUser->setFullName($fullName);
        $newUser->activate();
        if($newUser->saveToDB($conn)){
            echo 'Registration Successfull <br>';
        } else{
            echo 'Error during registration<br>';
        }
        
    }    
    else{
           if(!$email){
            echo 'Incorrect email';
           }
           if(!$password){
               echo 'Incorrect password';
           }
           if(!$retypedPassword || $password != $retypedPassword){
               echo 'Incorrect retyped password <br>';
           }
           if(!$fullName){
               echo("Incorrect name.<br>");
           }
           if($user){
               echo("User email exists<br>");
           }
}
}



?>

<html>
    <head></head>
    
    <body>
        
        
        
        <form method="POST">
            <fieldset>
                <label>
                Email:
                <input type="text" name="email" />
                </label>
                <br>
                <label>
                    Password:
                    <input type="password" name="password" />
                </label>
                <br>
                <label>
                    Retype password:
                    <input type="password" name="retypedPassword">
                </label>
                <br>
                <label>
                    Full name:
                    <input type="text" name="fullName"/>
                </label>
                <br>
                <input type="submit" value="Reqister"/>
                
            </fieldset>
        </form>
        
        
        
        
        
        
        
        
    </body>
  
</html>