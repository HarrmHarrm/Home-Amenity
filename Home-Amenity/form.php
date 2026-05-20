<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';

$success = "";
$error = "";

if(isset($_POST['submit_feedback'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $feedback = trim($_POST['feedback']);

    if(!empty($name) && !empty($email) && !empty($feedback)){

        $mail = new PHPMailer(true);

        try{

            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username = 'homeamenity123@gmail.com';

            $mail->Password = 'ketz saum tkrk tzkd';

            $mail->SMTPSecure = 'tls';

            $mail->Port = 587;

            $mail->setFrom('homeamenity123@gmail.com', 'Home Amenity');

            $mail->addAddress('homeamenity123@gmail.com');

            $mail->isHTML(true);

            $mail->Subject = 'New Feedback - Home Amenity';

            $mail->Body = "

                <h2>New Customer Feedback</h2>

                <p><strong>Name:</strong> $name</p>

                <p><strong>Email:</strong> $email</p>

                <p><strong>Feedback:</strong><br>$feedback</p>

            ";

            $mail->send();

            $success = "✅ Feedback sent successfully.";

        }catch(Exception $e){

            $error = "❌ Mail could not be sent.";

        }

    }else{

        $error = "❌ Please fill all fields.";

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Feedback - Home Amenity</title>

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:'Inter',sans-serif;

    background:linear-gradient(135deg,#eef5fb,#f8fafc);

    min-height:100vh;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:20px;
}

.feedback-container{

    width:100%;

    max-width:550px;

    background:white;

    padding:40px;

    border-radius:28px;

    box-shadow:0 20px 50px rgba(0,0,0,0.08);
}

.logo{

    text-align:center;

    margin-bottom:20px;
}

.logo img{

    width:80px;
}

h1{

    text-align:center;

    font-size:2rem;

    margin-bottom:10px;

    color:#0f172a;
}

.subtitle{

    text-align:center;

    color:#64748b;

    margin-bottom:35px;
}

.form-group{

    margin-bottom:22px;
}

label{

    display:block;

    margin-bottom:8px;

    font-weight:600;

    color:#334155;
}

input,
textarea{

    width:100%;

    padding:14px 16px;

    border:2px solid #e2e8f0;

    border-radius:16px;

    outline:none;

    font-size:1rem;

    transition:0.3s;
}

input:focus,
textarea:focus{

    border-color:#0088dd;
}

textarea{

    min-height:150px;

    resize:vertical;
}

.submit-btn{

    width:100%;

    padding:15px;

    border:none;

    border-radius:18px;

    background:linear-gradient(135deg,#009900,#007acc);

    color:white;

    font-size:1rem;

    font-weight:700;

    cursor:pointer;

    transition:0.3s;
}

.submit-btn:hover{

    transform:translateY(-2px);

    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.message{

    text-align:center;

    padding:12px;

    border-radius:12px;

    margin-bottom:20px;

    font-weight:600;
}

.success{

    background:#ecfdf5;

    color:#065f46;
}

.error{

    background:#fef2f2;

    color:#991b1b;
}

/* RESPONSIVE */

@media(max-width:600px){

    .feedback-container{

        padding:28px 22px;
    }

    h1{

        font-size:1.7rem;
    }
}

</style>

</head>

<body>

<div class="feedback-container">

    <div class="logo">

        <img src="images/Home.png" alt="Logo">

    </div>

    <h1>Feedback Form</h1>

    <p class="subtitle">

        Share your reviews, suggestions or complaints with us.

    </p>

    <?php if(!empty($success)): ?>

        <div class="message success">

            <?php echo $success; ?>

        </div>

    <?php endif; ?>

    <?php if(!empty($error)): ?>

        <div class="message error">

            <?php echo $error; ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="form-group">

            <label>Your Name</label>

            <input
            type="text"
            name="name"
            placeholder="Enter your name"
            required>

        </div>

        <div class="form-group">

            <label>Email Address</label>

            <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required>

        </div>

        <div class="form-group">

            <label>Your Feedback</label>

            <textarea
            name="feedback"
            placeholder="Write your feedback or complaint..."
            required></textarea>

        </div>

        <button type="submit" name="submit_feedback" class="submit-btn">

            Send Feedback

        </button>

    </form>

</div>

</body>
</html>