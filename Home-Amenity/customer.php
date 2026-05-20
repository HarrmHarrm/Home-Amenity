<?php
session_start();

// ================= DATABASE =================
$host = "localhost";
$user = "root";
$pass = "Harrm$1004";
$db   = "homeamenity";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// ================= SUBMIT FEEDBACK =================
$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $rating  = $_POST['rating'] ?? '';
    $feedback = trim($_POST['feedback']);

    // OPTIONAL IDS
    $customer_id = $_SESSION['customer_id'] ?? NULL;
    $worker_id   = $_SESSION['worker_id'] ?? NULL;
    $booking_id  = $_SESSION['booking_id'] ?? NULL;

    // ================= IMAGE UPLOAD =================
    $pictureName = "";

    if(isset($_FILES['work_picture']) && $_FILES['work_picture']['error'] == 0){

        $uploadDir = "uploads/feedback/";

        // create folder if not exists
        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        $pictureName = time() . "_" . basename($_FILES['work_picture']['name']);

        $targetFile = $uploadDir . $pictureName;

        move_uploaded_file($_FILES['work_picture']['tmp_name'], $targetFile);
    }

    // ================= INSERT INTO DATABASE =================
    $stmt = $conn->prepare("
        INSERT INTO feedback
        (customer_id, worker_id, booking_id, rating, feedback, picture)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "iiiiss",
        $customer_id,
        $worker_id,
        $booking_id,
        $rating,
        $feedback,
        $pictureName
    );

    if($stmt->execute()){
        $message = "Feedback submitted successfully!";
    }else{
        $message = "Something went wrong!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Page - Home Amenity</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background:#f4f7fb;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            padding:20px;
        }

        .container{
            background:#fff;
            width:100%;
            max-width:650px;
            padding:35px;
            border-radius:18px;
            box-shadow:0 8px 25px rgba(0,0,0,0.1);
        }

        h1{
            color:#0088dd;
            margin-bottom:10px;
            text-align:center;
        }

        .thankyou{
            text-align:center;
            color:#444;
            font-size:17px;
            margin-bottom:30px;
        }

        .chat-btn{
            display:block;
            width:220px;
            margin:0 auto 30px;
            text-align:center;
            background:#00b300;
            color:#fff;
            text-decoration:none;
            padding:14px;
            border-radius:10px;
            font-size:18px;
            font-weight:bold;
        }

        .chat-btn:hover{
            background:#009900;
        }

        .section-title{
            font-size:20px;
            margin-bottom:15px;
            color:#222;
        }

        .stars{
            display:flex;
            justify-content:center;
            flex-direction:row-reverse;
            margin-bottom:30px;
        }

        .stars input{
            display:none;
        }

        .stars label{
            font-size:40px;
            color:#ccc;
            cursor:pointer;
        }

        .stars input:checked ~ label,
        .stars label:hover,
        .stars label:hover ~ label{
            color:gold;
        }

        textarea{
            width:100%;
            min-height:130px;
            padding:15px;
            border:1px solid #ccc;
            border-radius:10px;
            resize:none;
            font-size:16px;
            margin-bottom:25px;
        }

        .upload-box{
            margin-bottom:25px;
        }

        .submit-btn{
            width:100%;
            background:#0088dd;
            color:#fff;
            border:none;
            padding:15px;
            border-radius:10px;
            font-size:18px;
            cursor:pointer;
        }

        .submit-btn:hover{
            background:#006fc0;
        }

        .success{
            background:#d4edda;
            color:#155724;
            padding:12px;
            border-radius:8px;
            margin-bottom:20px;
            text-align:center;
        }

        @media(max-width:600px){
            .container{
                padding:25px;
            }

            .stars label{
                font-size:32px;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Home Amenity</h1>

    <?php if($message != ""){ ?>
        <div class="success">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <p class="thankyou">
        Thanks for choosing Home Amenity! <br>
        We hope you had a great experience with your hired worker.
    </p>

    <a href="customer/create_chat.php" class="chat-btn">
        Chat With Worker
    </a>

    <form action="" method="POST" enctype="multipart/form-data">

        <div class="section-title">Rate Your Worker</div>

        <div class="stars">

            <input type="radio" name="rating" id="star5" value="5">
            <label for="star5">&#9733;</label>

            <input type="radio" name="rating" id="star4" value="4">
            <label for="star4">&#9733;</label>

            <input type="radio" name="rating" id="star3" value="3">
            <label for="star3">&#9733;</label>

            <input type="radio" name="rating" id="star2" value="2">
            <label for="star2">&#9733;</label>

            <input type="radio" name="rating" id="star1" value="1">
            <label for="star1">&#9733;</label>

        </div>

        <div class="upload-box">

            <div class="section-title">
                Upload Picture of Completed Work (Optional)
            </div>

            <input type="file" name="work_picture" accept="image/*">

        </div>

        <div class="section-title">Feedback</div>

        <textarea
            name="feedback"
            placeholder="Write your feedback here..."
            required
        ></textarea>

        <button type="submit" class="submit-btn">
            Submit Review
        </button>

    </form>

</div>

</body>
</html>