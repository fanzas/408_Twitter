<?php


include_once "src/tweet.php";
include_once "src/comment.php";
if($_SERVER['REQUEST_METHOD'] = "GET"){
    $tweetId = $_GET["tweetId"];

    $tweetToShow = new Tweet();
    $tweetToShow->loadTweetFromDB($conn, $tweetId);
    $tweetAuthorName = $tweetToShow->getTweetAuthorName($conn);
    

    $tweetText = $tweetToShow->getTweetText();
    echo("<br>");
    echo("Tweet Author: <br>");
    echo("$tweetAuthorName <br>");
    echo("Tweet text: <br>");
    echo("$tweetText");
}
    $comment = new Comment();
    $comments = $comment->loadCommentsFromDB($conn, $tweetId);
    if(count($comments) == 1){
        echo("<br>"."This post has ".count($comments)." comment.");
    }
    else{
        echo("<br>"."This post has ".count($comments)." comments.");
    }
    echo("<br>");


    
?>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <ul>
            <?php
            $commentsArray = array();
            foreach($comments as $val){
                $author = $val->getCommentAuthorName($conn);
                $comment = $val->getCommentText($conn);
                echo("<li>");
                echo "autor: ".$author."<br>";
                echo $comment."<br>";
                echo("</li>");
            }
            ?>
        </ul>
    </body>
</html>