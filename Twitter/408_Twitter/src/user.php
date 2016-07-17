<?php

include "connection.php";

class User {
    
    public static function getUserByEmail(mysqli $conn, $email){
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            return $userRow = $result->fetch_assoc();
        }    
        else {
            return false;
        }
    }
    
    public static function login(mysqli $conn, $email, $password){
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $rowUser = $result->fetch_assoc();
            if(password_verify($password, $rowUser['password']) && $rowUser['active'] == 1){
                return $rowUser['id'];
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    
    
    private $id;
    private $email;
    private $password;
    private $fullName;
    private $active;
    
    public function __construct(){
        $this->id = -1;
        $this->email = " ";
        $this->password = " ";
        $this->fullName = " ";
        $this->active = 0;
    }
    
    public function setEmail ($email){
        $this->email = is_string($email) ? trim($email): $this->email;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setPassword($password, $retypedPassword){
        if($password != $retypedPassword){
            return false;
        }
        else{
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        return true;
        }
    }
    public function getPassword(){
        return $this->password;
    }
    
    public function setFullName($fullName){
        $this->fullName = is_string($fullName) ? trim($fullName) : " ";
    }
    
    public function getFullName(){
        return $this->fullName;
    }
    
    public function activate(){
        $this->active = 1;
    }
    
    public function deactivate(){
        $this->acive = 0;
    }
    
    public function getActive(){
        return $this->active;
    }
    
    public function saveToDB(mysqli $conn) {
        if($this->id == -1) {
            $sql = "INSERT INTO User (email, password, fullName, active)
                    VALUES ('{$this->email}', '{$this->password}', '{$this->fullName}', {$this->active})";
            if($conn->query($sql)){
                $this->id = $conn->insert_id;
                return true;
            }
            else{
                echo $conn->error;
                return false;
            }
        }
        else {
            $sql = "UPDATE User SET email = '{$this->email}', fullName = '{$this->fullName}', active = {$this->active} WHERE id = {$this->id}";
                
        }
    }
    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM User WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $rowUser = $result->fetch_assoc();
            $this->id = $rowUser['id'];
            $this->email = $rowUser['email'];
            $this->password = $rowUser['password'];
            $this->fullName = $rowUser['fullName'];
            $this->active = $rowUser['active'];
        }
        return null;
    }

    public function loadAllTweets(mysqli $conn){
        $userId = $this->id;
        $userTweets = [];
        $sql = "SELECT * FROM Tweets WHERE user_id=$userId";
        $result = $conn->query($sql);
        if($result->num_rows > 0){    
            while($row=$result->fetch_assoc()){
                $tweet = new Tweet();
                $tweet->id = $row['id'];
                $tweet->setUserId($row['user_id']);
                $tweet->setTweetText($row['text']);
                $userTweets[]=$tweet;
            }
            return $userTweets;
        }
        
        }
}

