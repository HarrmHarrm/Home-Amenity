<?php
include("../includes/db.php");

$room_id = $_GET['room_id'];

$sender_type = "worker";
$sender_id = 2;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Worker Chat</title>
    <link rel="stylesheet" href="../chat/chat.css">
    </head>
<body>

<div class="chat-container">

    <div class="chat-header">
        Worker Chat Panel
    </div>

    <div id="messages"></div>

    <form id="chatForm" class="chat-form">

        <input type="hidden" name="room_id"
        value="<?php echo $room_id; ?>">

        <input type="hidden" name="sender_id"
        value="<?php echo $sender_id; ?>">

        <input type="hidden" name="sender_type"
        value="<?php echo $sender_type; ?>">

        <input type="text"
        name="message"
        id="messageInput"
        placeholder="Type message..."
        required>

        <button type="submit">Send</button>

    </form>

</div>

<script>
    function loadMessages(){

    fetch('../chat/fetch_messages.php?room_id=<?php echo $room_id; ?>&current_user=worker')
    .then(response => response.text())
    .then(data => {

        document.getElementById('messages').innerHTML = data;

        document.getElementById('messages').scrollTop =
        document.getElementById('messages').scrollHeight;
    });
}

setInterval(loadMessages,1000);

loadMessages();

document.getElementById('chatForm')
.addEventListener('submit', function(e){

    e.preventDefault();

    let formData = new FormData(this);

    fetch('../chat/send_message.php',{
        method:'POST',
        body:formData
    })
    .then(response => response.text())
    .then(data => {

        document.getElementById('messageInput').value='';

        loadMessages();
    });
});

</script>

</body>
</html>
