<?php
include("../includes/db.php");

$room_id = $_GET['room_id'];

$sql = "SELECT * FROM messages
WHERE room_id='$room_id'
ORDER BY created_at ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>View Chat</title>

<style>

body{
    font-family:Arial;
    background:#ece5dd;
}

.chat-box{
    width:700px;
    margin:30px auto;
    background:white;
    padding:20px;
    border-radius:10px;
}

.message{
    padding:10px 15px;
    margin:10px 0;
    border-radius:10px;
    max-width:70%;
}

.customer{
    background:#dcf8c6;
    margin-left:auto;
}

.worker{
    background:#ffffff;
}

.sender{
    font-size:12px;
    color:gray;
    margin-bottom:5px;
}

</style>

</head>
<body>

<div class="chat-box">

<h2>Chat Room #<?php echo $room_id; ?></h2>

<?php while($row = $result->fetch_assoc()) { ?>

<div class="message <?php echo $row['sender_type']; ?>">

    <div class="sender">

        <?php echo strtoupper($row['sender_type']); ?>

    </div>

    <?php echo htmlspecialchars($row['message']); ?>

</div>

<?php } ?>

</div>

</body>
</html>