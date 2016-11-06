<?php

$servername = 'localhost';
$username = 'root';
$password = 'CodersLab';
$basename = 'twitter';

$conn = new mysqli(
        $servername,
        $username,
        $password,
        $basename
        );

if ($conn->connect_error) {
    echo "Failed to connect to MYSQL. Error: $conn->error.<br>";
} 

//$conn->close();
//$conn = null;

?>

