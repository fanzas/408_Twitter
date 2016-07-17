<!DOCTYPE html>

<?php
include_once "index.php";
include_once "src/user.php";
$loggedUser = new User;
$loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['newPassword'])){
    $newPassword = $_POST['newPassword'];
    $oldPassword = $_POST['oldPassword'];
    $oldPassword = password_hash($oldPassword, PASSWORD_BCRYPT);
    
    
    $userPassword = $loggedUser->getPassword();
    
    
    if($userPassword == $oldPassword){
        $loggedUser->password = password_hash($newPassword, PASSWORD_BCRYPT);
    }
    else{
        echo("Type correct password");
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="POST" action="editUser.php">
            <fieldset style="display: inline-block">
                <legend>Change password:</legend>
            <br>
            Type old password:
            <input type="password" name="oldPassword">
            <br>
            Type new Password:
            <input type="password" name="newPassword">
            <br>
            Retype new password:
            <input type="password" name="checkNewPassword">
            <br>
            <input type="submit" name="setNewPassword">
            </fieldset>
        </form>
        <br>
        
        
        <form method="POST" action="editUser.php">
            <fieldset style="display: inline-block">
            <legend>Or change name:</legend>
            <input type="text" name="newName">
            <input type="submit" name="setNewName">
            </fieldset>
        </form>
    </body>
</html>
