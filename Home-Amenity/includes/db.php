<?php
$host = "localhost";
$user = "root";
$pass = "Harrm$1004";
$db 
  = "homeamenity";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>