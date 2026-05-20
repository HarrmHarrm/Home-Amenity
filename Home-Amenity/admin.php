<?php 
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';

// ==================== DATABASE CONFIG ====================
$host = "localhost";
$user = "root";
$pass = 'Harrm$1004';
$db   = "homeamenity";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die(" Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// ==================== HANDLE LOGOUT EARLY ====================
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// ==================== ADMIN LOGIN CHECK ====================
$admin_password = 'admin$123';

$is_logged_in = isset($_SESSION['admin_logged_in']) 
    && $_SESSION['admin_logged_in'] === true;

if (isset($_POST['admin_login']) && $_POST['admin_password'] === $admin_password) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (!$is_logged_in) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Home Amenity</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0a0f1e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            animation: blobFloat 8s ease-in-out infinite alternate;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #0066ff, #00ccff);
            top: -100px; left: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #00b300, #00ffcc);
            bottom: -80px; right: -80px;
            animation-delay: -4s;
        }

        @keyframes blobFloat {
            0%   { transform: translate(0, 0) scale(1); }
            100% { transform: translate(40px, 30px) scale(1.08); }
        }

        .login-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 28px;
            padding: 52px 44px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 1;
            box-shadow: 0 32px 64px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.08);
            animation: cardIn 0.6s cubic-bezier(0.34,1.56,0.64,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .logo-ring {
            width: 72px; height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0088ff, #00cc88);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
            font-size: 28px;
            box-shadow: 0 0 32px rgba(0,136,255,0.4);
        }

        .login-card h1 {
            color: #ffffff;
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .login-card p {
            color: rgba(255,255,255,0.45);
            font-size: 0.9rem;
            margin-bottom: 32px;
        }

        .input-wrap {
            position: relative;
            margin-bottom: 16px;
        }

        .input-wrap span {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            opacity: 0.4;
        }

        .password-input {
            width: 100%;
            padding: 14px 16px 14px 42px;
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            font-size: 0.95rem;
            font-family: inherit;
            color: #fff;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        .password-input::placeholder { color: rgba(255,255,255,0.3); }

        .password-input:focus {
            border-color: #0088ff;
            background: rgba(0,136,255,0.08);
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #0088ff 0%, #00cc88 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            font-family: inherit;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 8px 24px rgba(0,136,255,0.35);
            letter-spacing: 0.01em;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0,136,255,0.45);
        }

        .login-btn:active { transform: translateY(0); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-ring">🏠</div>
        <h1>Admin Access</h1>
        <p>Enter your password to access the dashboard</p>
        <form method="POST">
            <div class="input-wrap">
                <span>🔑</span>
                <input type="password" name="admin_password" class="password-input" placeholder="Enter password" required autofocus>
            </div>
            <button type="submit" name="admin_login" class="login-btn">Sign In →</button>
        </form>
    </div>
</body>
</html>
<?php
exit;
}

// ==================== DETERMINE ACTIVE SECTION ====================
$section = $_GET['section'] ?? 'users';

// ==================== HANDLE WORKER ACCESS ACTIONS ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['worker_action'], $_POST['worker_id'])) {

    $worker_id = (int)$_POST['worker_id'];
    $new_status = $_POST['worker_action'];

    if (in_array($new_status, ['allowed', 'denied'])) {

        $otp = rand(100000, 999999);

        $stmt = $conn->prepare("SELECT email FROM workers WHERE id = ?");
        $stmt->bind_param("i", $worker_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $worker = $result->fetch_assoc();
        $worker_email = $worker['email'];
        $stmt->close();

        $stmt = $conn->prepare("UPDATE workers SET access_status = ?, otp = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_status, $otp, $worker_id);
        $stmt->execute();
        $stmt->close();

        if ($new_status === 'allowed') {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'homeamenity123@gmail.com';
                $mail->Password   = 'ketz saum tkrk tzkd';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
                $mail->setFrom('homeamenity123@gmail.com', 'Home Amenity');
                $mail->addAddress($worker_email);
                $mail->isHTML(true);
                $mail->Subject = 'Home Amenity Worker OTP';
                $mail->Body    = "
                    <h2>Home Amenity</h2>
                    <p>Your OTP for Worker Dashboard login is:</p>
                    <h1>$otp</h1>
                    <p>Enter this OTP in worker_login.php</p>
                ";
                $mail->send();
            } catch (Exception $e) {
                echo 'Email could not be sent.';
            }
        }
    }

    header("Location: " . $_SERVER['PHP_SELF'] . "?section=workers");
    exit;
}

// ==================== FETCH USERS ====================
if ($section === 'users') {
    $result    = $conn->query("SELECT id, name, email_phone, created_at FROM login ORDER BY id DESC");
    $totalRows = $result ? $result->num_rows : 0;
}

// ==================== FETCH WORKERS ====================
if ($section === 'workers') {
    $workers_result = $conn->query("SELECT * FROM workers ORDER BY id DESC");
    $totalWorkers   = $workers_result ? $workers_result->num_rows : 0;
}

// ==================== FETCH BOOKINGS ====================
if ($section === 'bookings') {
    $bookings_result = $conn->query("
        SELECT 
            b.id,
            b.worker_id        AS raw_worker_id,
            w.worker_id        AS formatted_worker_id,
            w.name             AS worker_name,
            b.service,
            b.city,
            b.booking_time,
            b.hourly_rate,
            b.created_at
        FROM booking b
        LEFT JOIN workers w ON w.id = b.worker_id
        ORDER BY b.id DESC
    ");
    $totalBookings = $bookings_result ? $bookings_result->num_rows : 0;
}

// ==================== FETCH FEEDBACK ====================
if ($section === 'feedback') {
    $feedback_result = $conn->query("
        SELECT 
            feedback_id,
            worker_id,
            booking_id,
            rating,
            feedback,
            picture,
            created_at
        FROM feedback
        ORDER BY feedback_id DESC
    ");
    $totalFeedback = $feedback_result ? $feedback_result->num_rows : 0;
}

// ==================== SECTION BADGE TEXT ====================
$sectionBadge = '';
if ($section === 'users')    $sectionBadge = "Total users: $totalRows";
if ($section === 'workers')  $sectionBadge = "Total workers: $totalWorkers";
if ($section === 'bookings') $sectionBadge = "Total bookings: $totalBookings";
if ($section === 'feedback') $sectionBadge = "Total feedback: $totalFeedback";
if ($section === 'chat')     $sectionBadge = "Live Chat Viewer";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel — Home Amenity</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>

/* ============================================================
   RESET & VARIABLES
   ============================================================ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --blue:        #0078f5;
    --blue-light:  #e8f2ff;
    --blue-glow:   rgba(0,120,245,0.15);
    --green:       #00b34a;
    --green-light: #e6f9ef;
    --red:         #e03e3e;
    --red-light:   #fff1f1;
    --white:       #ffffff;
    --bg:          #f0f4fa;
    --surface:     #ffffff;
    --surface-2:   #f7f9fc;
    --border:      #e4eaf2;
    --text-1:      #0f1728;
    --text-2:      #4a5568;
    --text-3:      #8a96a8;
    --sidebar-w:   240px;
    --header-h:    66px;
    --radius:      14px;
    --shadow-sm:   0 2px 8px rgba(15,23,40,0.06);
    --shadow-md:   0 8px 24px rgba(15,23,40,0.09);
    --font:        'Plus Jakarta Sans', sans-serif;
}

body {
    font-family: var(--font);
    background: var(--bg);
    color: var(--text-1);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* ============================================================
   TOP HEADER BAR
   ============================================================ */
.topbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: var(--header-h);
    background: var(--white);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    padding: 0 28px;
    z-index: 100;
    box-shadow: var(--shadow-sm);
    gap: 14px;
}

.topbar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 800;
    font-size: 1.08rem;
    color: var(--text-1);
    letter-spacing: -0.02em;
    text-decoration: none;
    flex-shrink: 0;
}

.brand-icon {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, var(--blue), #00b8f5);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    box-shadow: 0 4px 12px rgba(0,120,245,0.3);
    flex-shrink: 0;
}

.topbar-divider {
    width: 1px; height: 28px;
    background: var(--border);
    flex-shrink: 0;
}

.topbar-title {
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--text-3);
}

.topbar-spacer { flex: 1; }

.topbar-badge {
    background: var(--blue-light);
    color: var(--blue);
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.01em;
    flex-shrink: 0;
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 8px 18px;
    background: var(--red-light);
    color: var(--red);
    border: 1.5px solid #ffd6d6;
    border-radius: 10px;
    font-size: 0.82rem;
    font-weight: 700;
    font-family: var(--font);
    cursor: pointer;
    text-decoration: none;
    transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
    flex-shrink: 0;
}

.logout-btn:hover {
    background: #ffe0e0;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(224,62,62,0.2);
}

/* ============================================================
   LAYOUT
   ============================================================ */
.layout {
    display: flex;
    margin-top: var(--header-h);
    min-height: calc(100vh - var(--header-h));
}

/* ============================================================
   SIDEBAR
   ============================================================ */
.sidebar {
    position: fixed;
    top: var(--header-h);
    left: 0;
    width: var(--sidebar-w);
    height: calc(100vh - var(--header-h));
    background: var(--white);
    border-right: 1px solid var(--border);
    padding: 20px 14px;
    display: flex;
    flex-direction: column;
    gap: 3px;
    overflow-y: auto;
    z-index: 90;
}

.sidebar-label {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: var(--text-3);
    padding: 12px 10px 5px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--text-2);
    text-decoration: none;
    transition: background 0.14s, color 0.14s, transform 0.14s;
    position: relative;
}

.nav-item:hover {
    background: var(--surface-2);
    color: var(--text-1);
    transform: translateX(2px);
}

.nav-item.active {
    background: var(--blue-light);
    color: var(--blue);
}

.nav-item.active::before {
    content: '';
    position: absolute;
    left: -14px;
    top: 22%; bottom: 22%;
    width: 3px;
    background: var(--blue);
    border-radius: 0 4px 4px 0;
}

.nav-icon {
    font-size: 1rem;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
}

/* ============================================================
   MAIN CONTENT AREA
   ============================================================ */
.main {
    margin-left: var(--sidebar-w);
    flex: 1;
    padding: 30px 32px;
    min-width: 0;
}

/* ============================================================
   PAGE HEADER
   ============================================================ */
.page-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 22px;
}

.page-header-icon {
    width: 46px; height: 46px;
    border-radius: 12px;
    background: var(--blue-light);
    color: var(--blue);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.page-header h2 {
    font-size: 1.3rem;
    font-weight: 800;
    letter-spacing: -0.02em;
    color: var(--text-1);
    line-height: 1.2;
}

.page-header p {
    font-size: 0.82rem;
    color: var(--text-3);
    margin-top: 2px;
}

/* ============================================================
   CARD / TABLE
   ============================================================ */
.card {
    background: var(--white);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.table-wrapper { overflow-x: auto; }

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

thead tr {
    background: var(--surface-2);
    border-bottom: 1.5px solid var(--border);
}

th {
    padding: 13px 16px;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--text-3);
    white-space: nowrap;
}

td {
    padding: 13px 16px;
    border-bottom: 1px solid var(--border);
    font-size: 0.875rem;
    color: var(--text-2);
    vertical-align: middle;
}

tbody tr:last-child td { border-bottom: none; }
tbody tr { transition: background 0.1s; }
tbody tr:hover { background: #fafcff; }

.id-chip {
    display: inline-block;
    background: var(--surface-2);
    border: 1px solid var(--border);
    color: var(--text-3);
    font-size: 0.73rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
    font-family: 'Courier New', monospace;
}

.worker-id-chip {
    display: inline-block;
    background: #eef5ff;
    border: 1px solid #c7deff;
    color: var(--blue);
    font-size: 0.73rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
}

.name-cell {
    font-weight: 600;
    color: var(--text-1);
}

/* ============================================================
   BADGES
   ============================================================ */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 11px;
    border-radius: 20px;
    font-size: 0.73rem;
    font-weight: 700;
}

.badge::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}

.badge-allowed  { background: var(--green-light); color: #065f2e; }
.badge-allowed::before  { background: var(--green); }
.badge-denied   { background: var(--red-light);   color: #991b1b; }
.badge-denied::before   { background: var(--red); }
.badge-pending  { background: #fff8e6; color: #92400e; }
.badge-pending::before  { background: #f59e0b; }

/* ============================================================
   BUTTONS
   ============================================================ */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 14px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.8rem;
    font-family: var(--font);
    transition: transform 0.12s, box-shadow 0.12s;
}

.btn:hover { transform: translateY(-1px); }

.btn-success {
    background: var(--green-light);
    color: #065f2e;
    border: 1px solid #9eedd5;
}
.btn-success:hover { background: #d1f5e3; box-shadow: 0 4px 10px rgba(0,179,74,0.15); }

.btn-danger {
    background: var(--red-light);
    color: #b91c1c;
    border: 1px solid #fecaca;
}
.btn-danger:hover { background: #ffe0e0; box-shadow: 0 4px 10px rgba(224,62,62,0.15); }

/* ============================================================
   RATING / FEEDBACK IMAGE
   ============================================================ */
.rating-cell {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-weight: 700;
    color: #b45309;
    background: #fffbeb;
    border: 1px solid #fde68a;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
}

.feedback-image {
    width: 68px; height: 68px;
    object-fit: cover;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    display: block;
}

/* ============================================================
   EMPTY STATE
   ============================================================ */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-3);
}
.empty-state .empty-icon { font-size: 2.5rem; margin-bottom: 12px; opacity: 0.4; }
.empty-state p { font-size: 0.9rem; font-weight: 500; }

/* ============================================================
   CHAT IFRAME
   ============================================================ */
.chat-frame-wrap {
    background: var(--white);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    height: calc(100vh - var(--header-h) - 150px);
    min-height: 500px;
}

.chat-frame-wrap iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 768px) {
    .sidebar { display: none; }
    .main { margin-left: 0; padding: 16px; }
    .topbar { padding: 0 16px; }
    .topbar-title, .topbar-divider { display: none; }
}

</style>
</head>
<body>

<!-- ==================== TOP BAR ==================== -->
<header class="topbar">

    <a href="?section=users" class="topbar-brand">
         <img src="images/Home.png" alt="Home Amenity Logo" class="brand-icon">
             Home Amenity
    </a>

    <div class="topbar-divider"></div>
    <span class="topbar-title">Admin Panel</span>

    <div class="topbar-spacer"></div>

    <?php if ($sectionBadge): ?>
        <span class="topbar-badge"><?= htmlspecialchars($sectionBadge) ?></span>
    <?php endif; ?>

    <a href="?logout=1" class="logout-btn">🔒 Logout</a>

</header>

<!-- ==================== LAYOUT ==================== -->
<div class="layout">

    <!-- SIDEBAR NAV -->
    <nav class="sidebar">

        <span class="sidebar-label">Management</span>

        <a href="?section=users"
           class="nav-item <?= $section === 'users'    ? 'active' : '' ?>">
            <span class="nav-icon">👥</span> Users
        </a>

        <a href="?section=workers"
           class="nav-item <?= $section === 'workers'  ? 'active' : '' ?>">
            <span class="nav-icon">🔧</span> Workers
        </a>

        <a href="?section=bookings"
           class="nav-item <?= $section === 'bookings' ? 'active' : '' ?>">
            <span class="nav-icon">📦</span> Bookings
        </a>

        <span class="sidebar-label">Engagement</span>

        <a href="?section=feedback"
           class="nav-item <?= $section === 'feedback' ? 'active' : '' ?>">
            <span class="nav-icon">⭐</span> Feedback
        </a>

        <a href="?section=chat"
           class="nav-item <?= $section === 'chat'     ? 'active' : '' ?>">
            <span class="nav-icon">💬</span> Chat
        </a>

    </nav>

    <!-- MAIN CONTENT -->
    <main class="main">

        <!-- ==================== USERS ==================== -->
        <?php if ($section === 'users'): ?>

        <div class="page-header">
            <div class="page-header-icon">👥</div>
            <div>
                <h2>Users</h2>
                <p>All registered users on the platform</p>
            </div>
        </div>

        <div class="card">
            <div class="table-wrapper">
                <?php if ($totalRows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email / Phone</th>
                            <th>Joined At</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><span class="id-chip">#<?= $row['id'] ?></span></td>
                            <td class="name-cell"><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email_phone']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">👤</div>
                    <p>No users found yet.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php endif; ?>

        <!-- ==================== WORKERS ==================== -->
        <?php if ($section === 'workers'): ?>

        <div class="page-header">
            <div class="page-header-icon">🔧</div>
            <div>
                <h2>Workers</h2>
                <p>Manage worker access and view registrations</p>
            </div>
        </div>

        <div class="card">
            <div class="table-wrapper">
                <?php if ($totalWorkers > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Worker ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $workers_result->fetch_assoc()):
                        $status = $row['access_status'] ?? 'pending';
                        if ($status === 'allowed')     $badge_class = 'badge-allowed';
                        elseif ($status === 'denied')  $badge_class = 'badge-denied';
                        else                           $badge_class = 'badge-pending';
                    ?>
                        <tr>
                            <td><span class="worker-id-chip"><?= htmlspecialchars($row['worker_id'] ?? 'W-'.$row['id']) ?></span></td>
                            <td class="name-cell"><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['city']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><span class="badge <?= $badge_class ?>"><?= ucfirst($status) ?></span></td>
                            <td>
                                <?php if ($status != 'allowed'): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="worker_action" value="allowed">
                                    <input type="hidden" name="worker_id" value="<?= $row['id'] ?>">
                                    <button class="btn btn-success">✅ Allow</button>
                                </form>
                                <?php endif; ?>
                                <?php if ($status != 'denied'): ?>
                                <form method="POST" style="display:inline; margin-left:4px;">
                                    <input type="hidden" name="worker_action" value="denied">
                                    <input type="hidden" name="worker_id" value="<?= $row['id'] ?>">
                                    <button class="btn btn-danger">⛔ Deny</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">🔧</div>
                    <p>No workers found yet.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php endif; ?>

        <!-- ==================== BOOKINGS ==================== -->
        <?php if ($section === 'bookings'): ?>

        <div class="page-header">
            <div class="page-header-icon">📦</div>
            <div>
                <h2>Bookings</h2>
                <p>All service bookings placed by users</p>
            </div>
        </div>

        <div class="card">
            <div class="table-wrapper">
                <?php if ($totalBookings > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Worker ID</th>
                            <th>Worker Name</th>
                            <th>Service</th>
                            <th>City</th>
                            <th>Booking Time</th>
                            <th>Hourly Rate</th>
                            <th>Booked At</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($booking = $bookings_result->fetch_assoc()):
                        $display_worker_id = !empty($booking['formatted_worker_id'])
                            ? $booking['formatted_worker_id']
                            : 'Tasker-ID-' . $booking['raw_worker_id'];
                        $display_worker_name = !empty($booking['worker_name'])
                            ? $booking['worker_name']
                            : 'N/A';
                    ?>
                        <tr>
                            <td><span class="id-chip">#<?= htmlspecialchars($booking['id']) ?></span></td>
                            <td><span class="worker-id-chip"><?= htmlspecialchars($display_worker_id) ?></span></td>
                            <td class="name-cell"><?= htmlspecialchars($display_worker_name) ?></td>
                            <td><?= htmlspecialchars($booking['service']) ?></td>
                            <td><?= htmlspecialchars($booking['city']) ?></td>
                            <td><?= htmlspecialchars($booking['booking_time']) ?> hrs</td>
                            <td>Rs. <?= htmlspecialchars($booking['hourly_rate']) ?></td>
                            <td><?= htmlspecialchars($booking['created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">📦</div>
                    <p>No bookings available yet.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php endif; ?>

        <!-- ==================== FEEDBACK ==================== -->
        <?php if ($section === 'feedback'): ?>

        <div class="page-header">
            <div class="page-header-icon">⭐</div>
            <div>
                <h2>Feedback</h2>
                <p>Customer reviews and ratings for workers</p>
            </div>
        </div>

        <div class="card">
            <div class="table-wrapper">
                <?php if ($totalFeedback > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Feedback ID</th>
                            <th>Worker ID</th>
                            <th>Booking ID</th>
                            <th>Rating</th>
                            <th>Feedback</th>
                            <th>Picture</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($feedback = $feedback_result->fetch_assoc()): ?>
                        <tr>
                            <td><span class="id-chip">#<?= htmlspecialchars($feedback['feedback_id']) ?></span></td>
                            <td><?= htmlspecialchars($feedback['worker_id']) ?></td>
                            <td><span class="id-chip">#<?= htmlspecialchars($feedback['booking_id']) ?></span></td>
                            <td><span class="rating-cell">⭐ <?= htmlspecialchars($feedback['rating']) ?>/5</span></td>
                            <td style="max-width:280px; line-height:1.55;"><?= nl2br(htmlspecialchars($feedback['feedback'])) ?></td>
                            <td>
                                <?php if (!empty($feedback['picture'])): ?>
                                    <img src="uploads/feedback/<?= htmlspecialchars($feedback['picture']) ?>" class="feedback-image">
                                <?php else: ?>
                                    <span style="color:var(--text-3); font-size:0.8rem;">No picture</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($feedback['created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">⭐</div>
                    <p>No feedback available yet.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php endif; ?>

        <!-- ==================== CHAT ==================== -->
        <?php if ($section === 'chat'): ?>

        <div class="page-header">
            <div class="page-header-icon">💬</div>
            <div>
                <h2>Chat</h2>
                <p>Live chat viewer between users and workers</p>
            </div>
        </div>

        <div class="chat-frame-wrap">
            <iframe src="admin/chats.php" title="Chat Viewer"></iframe>
        </div>

        <?php endif; ?>

    </main>
</div>

<?php $conn->close(); ?>
</body>
</html>