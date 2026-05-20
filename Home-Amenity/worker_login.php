<?php
session_start();

// ==================== DATABASE CONFIG ====================
$host = "localhost";
$user = "root";
$pass = "Harrm$1004";
$db   = "homeamenity";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ==================== REMEMBER ME (ONLY PREFILL) ====================
$remember_email = "";

if (isset($_COOKIE['worker_email'])) {
    $remember_email = $_COOKIE['worker_email'];
}

$message = "";

// ==================== LOGIN WITH EMAIL + OTP ====================
if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $otp   = trim($_POST['otp']);

    if (!empty($email) && !empty($otp)) {

        $stmt = $conn->prepare("
            SELECT * FROM workers 
            WHERE email = ? 
            AND otp = ? 
            AND access_status = 'allowed'
        ");

        $stmt->bind_param("ss", $email, $otp);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $worker = $result->fetch_assoc();

            // CREATE SESSION
            $_SESSION['worker_logged_in'] = true;
            $_SESSION['worker_id'] = $worker['id'];
            $_SESSION['worker_name'] = $worker['name'];
            $_SESSION['worker_email'] = $worker['email'];

            // ==================== REMEMBER ME (EMAIL ONLY) ====================
            if (isset($_POST['remember'])) {

                setcookie(
                    "worker_email",
                    $worker['email'],
                    time() + (86400 * 30), // 30 days
                    "/"
                );
            }

            header("Location: profile.php");
            exit;

        } else {
            $message = "Invalid Email or OTP";
        }

        $stmt->close();

    } else {
        $message = "Please enter Email and OTP";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Worker Login - Home Amenity</title>

<style>

:root{
    --blue:#0088dd;
    --green:#00b300;
    --white:#ffffff;
    --gray:#64748b;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, sans-serif;
    background:linear-gradient(160deg,#eef5fb,#f4f8f2);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.login-box{
    background:white;
    width:100%;
    max-width:400px;
    border-radius:20px;
    padding:40px 30px;
    box-shadow:0 20px 40px rgba(0,0,0,0.1);
    text-align:center;
}

.login-box img{
    width:90px;
    margin-bottom:10px;
}

.login-box h1{
    color:var(--blue);
    margin-bottom:8px;
}

.login-box p{
    color:var(--gray);
    margin-bottom:25px;
}

.input-box{
    width:100%;
    padding:14px;
    margin-bottom:15px;
    border:2px solid #e2e8ec;
    border-radius:12px;
    font-size:1rem;
    outline:none;
}

.input-box:focus{
    border-color:var(--blue);
}

.login-btn{
    width:100%;
    padding:14px;
    background:linear-gradient(135deg,var(--green),#00cc00);
    color:white;
    border:none;
    border-radius:12px;
    font-size:1rem;
    font-weight:bold;
    cursor:pointer;
}

.login-btn:hover{
    opacity:0.95;
}

.message{
    margin-top:15px;
    color:red;
    font-size:0.95rem;
}

</style>
</head>

<body>

<div class="login-box">

    <img src="images/Home.png" alt="Logo">

    <h1>Worker Login</h1>

    <p>Enter your Email and OTP</p>

    <form method="POST">

        <input 
            type="email" 
            name="email" 
            class="input-box"
            placeholder="Enter Email"
            value="<?= htmlspecialchars($remember_email) ?>"
            required
        >

        <input 
            type="text" 
            name="otp" 
            class="input-box"
            placeholder="Enter OTP"
            maxlength="6"
            required
        >

        <div style="display:flex;align-items:center;margin-bottom:18px;text-align:left;">
    
            <input 
                type="checkbox" 
                name="remember" 
                id="remember"
                style="width:18px;height:18px;cursor:pointer;"
            >

            <label 
                for="remember"
                style="margin-left:10px;color:#64748b;cursor:pointer;font-size:0.95rem;"
            >
                Remember Me
            </label>

        </div>

        <button type="submit" name="login" class="login-btn">
            Login
        </button>

    </form>

    <?php if(!empty($message)): ?>
        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>