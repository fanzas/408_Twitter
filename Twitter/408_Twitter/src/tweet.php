<?php

include "connection.php";


class Tweet{
    public $id;
    private $user_id;
    private $text;
    
    public function __construct(){
        $this->id = 1;
        $this->user_id = null;
        $this->text = null;
    }
    
    public function getId(){
        $id = $this->id;
        return $id;
    }
    
    public function getUserId(){
        return $this->user_id;
    }
    
    public function setUserId($userId){
        $this->user_id = $userId;
        return $userId;
    }
    
    public function setTweetText($newText){
        return $this->text = $newText;
    }
    
    public function getTweetText(){
        return $this->text;
    }
    
    
    
    public function addTweet(mysqli $conn){
       
        $sql = "INSERT INTO Tweets (user_id, text) VALUES ('{$this->user_id}', '{$this->text}')";
        
        if($conn->query($sql)){
                $this->id=$conn->insert_id;
                return true;
            }
            else{
                return false;
            }
        }

    public function loadTweetFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM Tweets WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $tweet = $result->fetch_assoc();
            $this->id = $tweet['id'];
            $this->user_id = $tweet['user_id'];
            $this->text = $tweet['text'];
        }
        return $tweet;
        
    }
    
    public function printTweet(mysqli $conn){
        echo($this->text."<br>");
    }
    
    public function getTweetAuthorName(mysqli $conn){
        $sql = "SELECT fullName FROM User WHERE id = $this->user_id";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $userName = $result->fetch_assoc();
            foreach($userName as $value){
                return $value;
            }
        }
    }
    
    
}


