<?php

include("../includes/db.php");

$room_id = $_GET['room_id'];
$current_user = $_GET['current_user'];

$sql = "SELECT * FROM messages
WHERE room_id='$room_id'
ORDER BY created_at ASC";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {

    $class = "";

    if($row['sender_type'] == $current_user){

        $class = "customer";

    } else {

        $class = "worker";
    }

    echo "<div class='message $class'>";

    // TEXT MESSAGE
    if(!empty($row['message'])){

        echo "<div>";

        echo htmlspecialchars($row['message']);

        echo "</div>";
    }

    // VOICE MESSAGE
    if(!empty($row['voice_message'])){

        $voice_path =
        "/PHP/Home-Amenity/uploads/voices/" .
        $row['voice_message'];

        echo "

        <audio controls style='margin-top:8px; width:220px;'>

            <source src='$voice_path' type='audio/webm'>

        </audio>

        ";
    }

    echo "</div>";
}
?>