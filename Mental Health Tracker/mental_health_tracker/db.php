<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "mental_health_tracker";

$con = mysqli_connect($server, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    //echo "Connected to MySQL";
}

?>
