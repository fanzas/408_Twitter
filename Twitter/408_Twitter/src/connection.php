<?php

$servername = "localhost";
$username = "root";
$password = "coderslab";
$baseName = "Twitter";

$conn = new mysqli($servername, $username, $password, $baseName);

if($conn->connect_error){
    echo("Nie udalo sie polaczyc z baza danych");
} else{
    echo("Nastapilo polaczenie z baza danych Twitter.");
}