<?php

session_start();

include("../includes/db.php");

?>

<!DOCTYPE html>
<html>
<head>

<title>Worker Inbox</title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
    padding:20px;
}

h2{
    margin-bottom:20px;
}

.chat-box{
    background:white;
    padding:15px;
    margin-bottom:15px;
    border-radius:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
}

.customer-info{
    font-size:18px;
    font-weight:bold;
    color:#333;
}

.chat-btn{
    background:#0084ff;
    color:white;
    padding:10px 18px;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
}

.chat-btn:hover{
    background:#006fe0;
}

</style>

</head>
<body>

<h2>Customer Chats</h2>

<!-- CUSTOMER ID 0 -->
<div class="chat-box">

    <div class="customer-info">
        Customer ID: 0
    </div>

    <a class="chat-btn" href="chat.php?room_id=0">
        Open Chat
    </a>

</div>

<!-- CUSTOMER ID 1 -->
<div class="chat-box">

    <div class="customer-info">
        Customer ID: 1
    </div>

    <a class="chat-btn" href="chat.php?room_id=1">
        Open Chat
    </a>

</div>

<!-- CUSTOMER ID 2 -->
<div class="chat-box">

    <div class="customer-info">
        Customer ID: 2
    </div>

    <a class="chat-btn" href="chat.php?room_id=2">
        Open Chat
    </a>

</div>

</body>
</html>