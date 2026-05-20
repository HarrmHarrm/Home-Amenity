<?php
session_start();

// ==================== DATABASE CONFIG ====================
$host = "localhost";
$user = "root";
$pass = "Harrm$1004";
$db   = "homeamenity";
$port = 3307;

// ==================== CONNECT DATABASE ====================
$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// =========================================================
// AUTHENTICATION CHECK
// =========================================================

if (!isset($_SESSION['worker_id'])) {
    die("Access denied. Worker not logged in.");
}

$worker_id = (int) $_SESSION['worker_id'];

// ==================== FETCH WORKER ====================
$stmt = $conn->prepare("SELECT * FROM workers WHERE id = ?");
$stmt->bind_param("i", $worker_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Worker not found.");
}

$worker = $result->fetch_assoc();
$stmt->close();

// ==================== FETCH BOOKINGS (ORDERS) ====================
$orders = [];
$new_orders_count = 0;

// Matches actual `booking` table created in workpro.php:
// columns: id, worker_id, name(customer), service, city, booking_time, hourly_rate, created_at
$order_sql = "SELECT id, city, service, booking_time, hourly_rate, created_at 
              FROM booking 
              WHERE worker_id = ? 
              ORDER BY created_at DESC";
$order_stmt = $conn->prepare($order_sql);
if ($order_stmt) {
    $order_stmt->bind_param("i", $worker_id);
    $order_stmt->execute();
    $order_result = $order_stmt->get_result();
    while ($row = $order_result->fetch_assoc()) {
        $orders[] = $row;
        // All new bookings count as notifications (no status column exists yet)
        $new_orders_count++;
    }
    $order_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Worker Profile</title>

<style>
/* ========== MODERN RESPONSIVE STYLES (unchanged except new modal adjustments) ========== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    background: #f1f5f9;
    padding: 1.5rem;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-box {
    max-width: 1100px;
    width: 100%;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 2rem;
    box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.15);
    overflow: hidden;
}

.top-section {
    background: linear-gradient(145deg, #007acc 0%, #005f99 100%);
    color: white;
    text-align: center;
    padding: 2.5rem 1.5rem 2rem;
}

.profile-image {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(255, 255, 255, 0.4);
    background: white;
    box-shadow: 0 12px 22px -8px rgba(0,0,0,0.2);
    transition: transform 0.2s ease;
}

.profile-image:hover {
    transform: scale(1.02);
}

.worker-name {
    margin-top: 1rem;
    font-size: 1.9rem;
    font-weight: 700;
}

.worker-category {
    margin-top: 0.75rem;
    display: inline-block;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(4px);
    padding: 0.4rem 1.2rem;
    border-radius: 3rem;
    font-weight: 600;
    font-size: 0.9rem;
}

.verify-badge {
    margin-top: 1.2rem;
    font-weight: 600;
    font-size: 0.8rem;
}

.verified {
    background: #009900;
    color: white;
    padding: 0.3rem 1rem;
    border-radius: 2rem;
    display: inline-block;
}

.not-verified {
    background: #f59e0b;
    color: #422006;
    padding: 0.3rem 1rem;
    border-radius: 2rem;
    display: inline-block;
}

.content {
    padding: 2rem 2rem 2.2rem;
}

.tasker-id {
    background: #eef6ff;
    border-left: 6px solid #007acc;
    padding: 1rem 1.5rem;
    border-radius: 1.2rem;
    margin-bottom: 2rem;
    font-size: 1rem;
    font-weight: 500;
    color: #0c4e6e;
    display: flex;
    flex-wrap: wrap;
    align-items: baseline;
    gap: 0.5rem;
}

.tasker-id strong {
    font-weight: 700;
    color: #007acc;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
}

.card {
    background: #ffffff;
    border: 1px solid #e4e9f0;
    padding: 1.4rem 1.2rem;
    border-radius: 1.5rem;
    transition: all 0.25s;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 20px -10px rgba(0, 122, 204, 0.12);
    border-color: #cbdde9;
}

.card h3 {
    color: #007acc;
    margin-bottom: 0.6rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.card h3::before {
    content: "●";
    font-size: 0.7rem;
    color: #009900;
}

.card p {
    color: #1f2e3a;
    font-size: 1rem;
    font-weight: 500;
}

/* Buttons with badge */
.actions {
    margin-top: 2.5rem;
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    text-decoration: none;
    padding: 0.7rem 1.8rem;
    border-radius: 3rem;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    position: relative;
    cursor: pointer;
    border: none;
    font-family: inherit;
}

.btn-orders {
    background: #007acc;
    color: white;
}

.btn-orders:hover {
    background: #005c99;
    transform: translateY(-2px);
}

.notification-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    padding: 0.2rem 0.5rem;
    font-size: 0.7rem;
    font-weight: bold;
    min-width: 1.4rem;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.9; }
    100% { transform: scale(1); opacity: 1; }
}

.btn-chatbox {
    background: #009900;
    color: white;
}

.btn-chatbox:hover {
    background: #007a00;
    transform: translateY(-2px);
}

.btn-home {
    background: #f1f5f9;
    color: #1e293b;
    border: 1px solid #cbd5e1;
}

.btn-home:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    width: 90%;
    max-width: 700px;
    border-radius: 2rem;
    box-shadow: 0 25px 40px rgba(0,0,0,0.3);
    animation: fadeInUp 0.3s ease;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.2rem 1.5rem;
    border-bottom: 1px solid #eef2f6;
    background: #007acc;
    color: white;
    border-radius: 2rem 2rem 0 0;
}

.modal-header h2 {
    font-size: 1.4rem;
    font-weight: 600;
}

.close-modal {
    font-size: 1.8rem;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
    line-height: 1;
}

.close-modal:hover {
    color: #ffcccc;
}

.modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    flex: 1;
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.order-card {
    background: #f8fafc;
    border-left: 5px solid #007acc;
    padding: 1rem;
    border-radius: 1rem;
    transition: 0.2s;
}

.order-card:hover {
    background: #f1f5f9;
}

.order-location {
    font-weight: 700;
    color: #0f3b2c;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.order-work {
    color: #1e4663;
    margin-bottom: 0.3rem;
}

.order-time {
    font-size: 0.85rem;
    color: #5a6e7c;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.order-status {
    display: inline-block;
    margin-top: 0.5rem;
    font-size: 0.7rem;
    padding: 0.2rem 0.6rem;
    border-radius: 1rem;
    background: #e2e8f0;
    color: #2d3748;
}

.status-pending {
    background: #fef3c7;
    color: #b45309;
}

.no-orders {
    text-align: center;
    color: #7f8c8d;
    padding: 2rem;
}

@media (max-width: 640px) {
    body { padding: 1rem; }
    .profile-box { border-radius: 1.5rem; }
    .top-section { padding: 1.8rem 1rem 1.5rem; }
    .profile-image { width: 100px; height: 100px; }
    .worker-name { font-size: 1.5rem; }
    .content { padding: 1.5rem; }
    .grid { gap: 1rem; }
    .card { padding: 1rem; }
    .btn { padding: 0.6rem 1.4rem; font-size: 0.85rem; }
    .modal-content { width: 95%; border-radius: 1.5rem; }
    .modal-header h2 { font-size: 1.2rem; }
}

@media (min-width: 641px) and (max-width: 1024px) {
    body { padding: 1.8rem; }
    .profile-box { max-width: 800px; }
    .worker-name { font-size: 1.8rem; }
    .grid { grid-template-columns: repeat(2, 1fr); }
}

@media (min-width: 1025px) {
    .profile-box { max-width: 1000px; }
    .grid { grid-template-columns: repeat(3, 1fr); }
}
</style>
</head>
<body>

<div class="profile-box">

    <div class="top-section">
        <?php if(!empty($worker['picture']) && file_exists('uploads/' . $worker['picture'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($worker['picture']); ?>" class="profile-image" alt="Worker Image">
        <?php else: ?>
            <img src="https://via.placeholder.com/130" class="profile-image" alt="Default Image">
        <?php endif; ?>
        <div class="worker-name"><?php echo htmlspecialchars($worker['name']); ?></div>
        <div class="worker-category"><?php echo htmlspecialchars($worker['category']); ?></div>
        <div class="verify-badge">
            <?php if($worker['confirmation'] == 1): ?>
                <span class="verified">✔ Verified Tasker</span>
            <?php else: ?>
                <span class="not-verified">Pending Verification</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="content">
        <div class="tasker-id">
            <strong>Tasker ID:</strong> <?php echo htmlspecialchars($worker['worker_id']); ?>
        </div>

        <div class="grid">
            <div class="card"><h3>City</h3><p><?php echo htmlspecialchars($worker['city']); ?></p></div>
            <div class="card"><h3>Experience</h3><p><?php echo (int)$worker['experience_years']; ?> Years</p></div>
            <div class="card"><h3>Hourly Rate</h3><p>Rs. <?php echo htmlspecialchars($worker['hourly_rate']); ?>/hour</p></div>
            <div class="card"><h3>Availability</h3><p><?php echo (int)$worker['availability_hours']; ?> hours/week</p></div>
            <div class="card"><h3>Phone</h3><p><?php echo !empty($worker['phone']) ? htmlspecialchars($worker['phone']) : 'Not Provided'; ?></p></div>
            <div class="card"><h3>Email</h3><p><?php echo !empty($worker['email']) ? htmlspecialchars($worker['email']) : 'Not Provided'; ?></p></div>
        </div>

        <div class="actions">
            <button class="btn btn-orders" id="ordersBtn">
                Orders
                <?php if ($new_orders_count > 0): ?>
                    <span class="notification-badge"><?php echo $new_orders_count; ?></span>
                <?php endif; ?>
            </button>
            <a href="worker/messages.php" class="btn btn-chatbox">Chatbox</a>
            <a href="home.php" class="btn btn-home">Home</a>
        </div>
    </div>
</div>

<!-- Orders Modal -->
<div id="ordersModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>📋 My Bookings</h2>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <?php if (empty($orders)): ?>
                <div class="no-orders">
                    <p>✨ No bookings yet. ✨</p>
                    <p style="font-size: 0.85rem;">When customers book you, orders will appear here.</p>
                </div>
            <?php else: ?>
                <div class="orders-list">
                    <?php foreach ($orders as $order): ?>
                        <div class="order-card">
                            <div class="order-location">📍 <strong><?php echo htmlspecialchars($order['city']); ?></strong></div>
                            <div class="order-work">🛠️ Task: <?php echo htmlspecialchars($order['service']); ?></div>
                            <div class="order-time">🕒 Booking Time: <?php echo htmlspecialchars($order['booking_time']); ?></div>
                            <div class="order-time">💰 Rate: Rs. <?php echo htmlspecialchars($order['hourly_rate']); ?>/hour</div>
                            <div class="order-time">📅 Booked On: <?php echo date('F j, Y g:i A', strtotime($order['created_at'])); ?></div>
                            <div class="order-status status-pending">
                                🔔 New Booking
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('ordersModal');
    const ordersBtn = document.getElementById('ordersBtn');
    const closeBtn = document.querySelector('.close-modal');

    ordersBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>

</body>
</html>