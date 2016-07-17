<?php

include "connection.php";

class Comment{
    public $id;
    public $comment;
    public $tweet_id;
    public $user_id;
    
    public function __construct(){
        $this->id = 1;
        $this->comment = null;
        $this->tweet_id = null;
        $this->user_id = null;
    }
    
    public function getId(){
        $id = $this->id;
        return $id;
    }
    
    public function getUserId(){
        return $this->user_id;
    }
    
    public function getTweetId(){
        return $this->tweet_id;
    }
    public function setComment($comment){
        $this->comment = $comment;
    }
    
    public function postComment(mysqli $conn){
        $sql = "INSERT INTO Comments (comment, tweet_id, user_id) VALUES ('{$this->comment}', '{$this->tweet_id}', '{$this->user_id}')";
        
        if($conn->query($sql)){
                $this->id = $conn->insert_id;
                return true;
            }
            else{
                return false;
            }
    }
    
    public function loadCommentsFromDB(mysqli $conn, $tweet_id){
        $sql = "SELECT * FROM Comments WHERE tweet_id = $tweet_id";
        $result = $conn->query($sql);
        $comments = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){
                $comment = new Comment;
                $comment->id = $row['id'];
                $comment->comment = $row['comment'];
                $comment->user_id = $row['user_id'];
                $comment->tweet_id = $row['tweet_id'];
                $comments[]=$comment;
            }
          
        }
        return $comments;
    }
    public function getCommentAuthorName(mysqli $conn){
        $sql = "SELECT fullName FROM User WHERE id = $this->user_id";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $userName = $result->fetch_assoc();
            foreach($userName as $value){
                return $value;
            }
        }
    }
    public function getCommentText(mysqli $conn){
        return $this->comment;
    }
    /*
    public function showCommentsAndAuthors(mysqli $conn){
        $comment = new Comment;
        $comments = $comment->loadCommentsFromDB($conn, $this->tweet_id);
        $commentsArray = array();
        foreach($comments as $val){
            $arrayKey = $val->getCommentAuthorName($conn);
            $keyVal = $val->getCommentText($conn);
    
            echo $arrayKey."<br>";
            echo $keyVal."<br>";
        }
    }
    */
    
}
/*
$comment = new Comment();
$comments = $comment->loadCommentsFromDB($conn, 14);
 var_dump($comments);
echo (count($comments));

var_dump($comments[1]->getCommentAuthorName($conn));


$commentsArray = array();
foreach($comments as $val){
    $arrayKey = $val->getCommentAuthorName($conn);
    $keyVal = $val->getCommentText($conn);
    
    echo $arrayKey."<br>";
    echo $keyVal."<br>";
}

*/

