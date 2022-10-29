<?php
    $host="localhost";
    $username="admin";
    $pass="password";
    $dbname="challenge_5a";
    $conn=mysqli_connect($host,$username,$pass,$dbname);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
?>