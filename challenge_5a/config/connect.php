<?php
    $host="localhost";
    $username="admin";
    $pass="password";
    $dbname="challenge5a_anhdv";
    $conn=mysqli_connect($host,$username,$pass,$dbname);
    if(!$conn){
        die("Connection failed: " . mysql_connect_error());
    }
?>