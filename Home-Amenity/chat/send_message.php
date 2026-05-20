<?php
include("../includes/db.php");

$room_id = $_POST['room_id'];
$sender_id = $_POST['sender_id'];
$sender_type = $_POST['sender_type'];
$message = $_POST['message'];

$sql = "INSERT INTO messages
(room_id, sender_id, sender_type, message)
VALUES
('$room_id','$sender_id','$sender_type','$message')";

$conn->query($sql);

echo "success";
?>