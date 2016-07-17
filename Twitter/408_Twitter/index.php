<?php

session_start();
include_once "src/tweet.php";
include_once "src/user.php";
if(!isset($_SESSION['loggedUserId'])){
    header('Location: login.php');
}
else{
    $loggedUser = new User();
    $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
}


$userId = (int)($_SESSION['loggedUserId']);

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['newTweet'])){
    $newTweet = new Tweet();
    
    $newTweet->setUserId($userId);
    $newTweet->setTweetText($_POST['newTweet']);

    if($newTweet->addTweet($conn)){
        echo "Tweet added";
    }
    else{
        echo "Error during adding Tweet";
    }
    
    
}

?>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            <?php 
             echo("Hello! ");
             echo($loggedUser->getFullName());
             echo(".");
            ?>
        </div>
        <br>
        <form action="index.php" method="POST">
        <input type="text" name="newTweet" maxlength="140">New tweet
        <br>
        <input type="submit">TWEET!
        </form>
        <a href="logout.php">Logout</a>
        <a href="editUser.php">Edit User</a>
        <?php
        $userTweets = $loggedUser->loadAllTweets($conn);
        ?>
        
        <ul>
        <?php
        if(count($userTweets) > 0){
          foreach($userTweets as $tweet){
            ?>
          <li>
            <form action="showTweet.php" id="showTweet" method="GET">
            <?php
            
              echo("Author: ".$loggedUser->getFullName());
              echo("<br>");
              $tweet->printTweet($conn);
              $tweetId = $tweet->getId()
            ?>
              <a href='showTweet.php?tweetId=<?php echo("$tweetId") ?>'>Tweet information</a><br>

            </form>
          </li>
            <?php
          }
        }else{
            echo("User hadn't twitted yet.");
        }
        
        ?>
            
        </ul>
    </body>
</html>