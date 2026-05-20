<?php

session_start();

include("../includes/db.php");

/*
TEMPORARY TESTING
Later replace with:

$_SESSION['customer_id']
*/

$customer_id = 1;

$worker_id = $_GET['worker_id'];


/*
CHECK IF ROOM ALREADY EXISTS
*/

$check = "SELECT * FROM chat_rooms
WHERE customer_id='$customer_id'
AND worker_id='$worker_id'";

$result = $conn->query($check);


/*
IF ROOM EXISTS
*/

if($result->num_rows > 0){

    $room = $result->fetch_assoc();

    $room_id = $room['id'];

} else {

    /*
    CREATE NEW ROOM
    */

    $insert = "INSERT INTO chat_rooms
    (customer_id, worker_id)
    VALUES
    ('$customer_id','$worker_id')";

    $conn->query($insert);

    $room_id = $conn->insert_id;
}


/*
REDIRECT TO CHAT
*/

header("Location: chat.php?room_id=$room_id");

?>