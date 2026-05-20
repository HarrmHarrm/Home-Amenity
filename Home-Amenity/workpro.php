<?php
// workpro.php — Admin-approved workers for the selected service and GPS city
// Responsive: mobile, tablet, desktop

// ==================== DATABASE CONNECTION ====================
$host = "localhost";
$user = "root";
$pass = 'Harrm$1004';
$db   = "homeamenity";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// ==================== GET PARAMETERS ====================
$service = trim($_GET['service'] ?? '');
$cityRaw = trim($_GET['city'] ?? '');
$bookingTime = $_GET['time'] ?? '0';

if (empty($service) || empty($cityRaw)) {
    echo "<p style='text-align:center;font-family:sans-serif;'>Missing service or city. Please go back and try again.</p>";
    exit;
}

// ==================== CITY CANONICAL MAPPING ====================
$cityCanonicalMap = [
    'fsd'         => 'faisalabad',
    'faisalabad'  => 'faisalabad',
    'lhr'         => 'lahore',
    'lahore'      => 'lahore',
    'isb'         => 'islamabad',
    'islamabad'   => 'islamabad',
    'khi'         => 'karachi',
    'karachi'     => 'karachi',
    'rwp'         => 'rawalpindi',
    'rawalpindi'  => 'rawalpindi',
];

// ==================== NORMALIZE CITY ====================
function normalizeCityCanonical($rawCity, $map) {

    $city = strtolower(trim($rawCity));
    $parts = explode(' ', $city, 2);
    $firstWord = $parts[0];

    return isset($map[$firstWord]) ? $map[$firstWord] : $firstWord;
}

$canonicalCity = normalizeCityCanonical($cityRaw, $cityCanonicalMap);

// ==================== CREATE BOOKING TABLE ====================
$createTable = "
CREATE TABLE IF NOT EXISTS booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    worker_id INT NOT NULL,
    worker_name VARCHAR(255),
    service VARCHAR(255),
    city VARCHAR(255),
    booking_time VARCHAR(50),
    hourly_rate VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
";

$conn->query($createTable);

// ==================== HANDLE BOOKING ====================
if (
    isset($_GET['hire']) &&
    $_GET['hire'] == '1' &&
    isset($_GET['worker_id'])
) {

    $workerId = intval($_GET['worker_id']);

    // Fetch worker details
    $workerSql = "SELECT * FROM workers WHERE id = ?";
    $workerStmt = $conn->prepare($workerSql);

    $workerStmt->bind_param("i", $workerId);
    $workerStmt->execute();

    $workerResult = $workerStmt->get_result();

    if ($workerResult->num_rows > 0) {

        $workerData = $workerResult->fetch_assoc();

        $workerName = $workerData['name'];
        $hourlyRate = $workerData['hourly_rate'];

        // Insert booking
        $insertSql = "
        INSERT INTO booking
        (worker_id, name, service, city, booking_time, hourly_rate)
        VALUES (?, ?, ?, ?, ?, ?)
        ";

        $insertStmt = $conn->prepare($insertSql);
        if (!$insertStmt) {
    die("Prepare failed: " . $conn->error);
}

        $insertStmt->bind_param(
            "isssss",
            $workerId,
            $name,
            $service,
            $canonicalCity,
            $bookingTime,
            $hourlyRate
        );

        if ($insertStmt->execute()) {

    echo "
    <script>

        window.location.href='customer.php?worker_id=".$workerId."&service=".urlencode($service)."';

    </script>
    ";

    exit;

} else {

    echo "<script>alert('Error saving booking.');</script>";
}
    }
}

// ==================== FETCH APPROVED WORKERS ====================

// Get all city aliases
$possibleCities = array_keys(
    array_filter(
        $cityCanonicalMap,
        function($value) use ($canonicalCity) {
            return $value === $canonicalCity;
        }
    )
);

// Fallback
if (empty($possibleCities)) {
    $possibleCities = [$canonicalCity];
}

$placeholders = implode(',', array_fill(0, count($possibleCities), '?'));

$sql = "
SELECT * FROM workers
WHERE LOWER(TRIM(category)) = LOWER(TRIM(?))
AND LOWER(TRIM(city)) IN ($placeholders)
AND access_status = 'allowed'
";

$stmt = $conn->prepare($sql);

$types = 's' . str_repeat('s', count($possibleCities));
$params = array_merge([$service], $possibleCities);

$stmt->bind_param($types, ...$params);

$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($service) ?>s in
        <?= htmlspecialchars($canonicalCity) ?> — Home Amenity
    </title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>

        /* ================= RESET ================= */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {

            font-family: 'Inter', sans-serif;

            background: linear-gradient(
                160deg,
                #eef5fb 0%,
                #f4f8f2 100%
            );

            min-height: 100vh;

            padding: 2rem 1rem;

            color: #1e293b;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ================= HEADING ================= */

        h2 {

            text-align: center;

            margin-bottom: 2.5rem;

            font-weight: 700;

            font-size: 1.8rem;

            color: #0f172a;
        }

        /* ================= GRID ================= */

        .worker-grid {

            display: grid;

            grid-template-columns: 1fr;

            gap: 1.5rem;

            justify-items: center;
        }

        /* Tablet */
        @media (min-width: 600px) {

            .worker-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Laptop */
        @media (min-width: 900px) {

            .worker-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Desktop */
        @media (min-width: 1100px) {

            .worker-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* ================= CARD ================= */

        .worker-card {

            background: white;

            border-radius: 1.25rem;

            box-shadow: 0 15px 30px rgba(0,0,0,0.08);

            padding: 1.8rem 1.5rem;

            width: 100%;

            max-width: 280px;

            text-align: center;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;

            display: flex;

            flex-direction: column;

            align-items: center;
        }

        .worker-card:hover {

            transform: translateY(-6px);

            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        /* ================= IMAGE ================= */

        .worker-image {

            width: 100px;
            height: 100px;

            border-radius: 50%;

            object-fit: cover;

            margin-bottom: 1rem;

            border: 3px solid #0088dd;

            background: #e2e8f0;
        }

        /* ================= TEXT ================= */

        .worker-name {

            font-weight: 700;

            font-size: 1.2rem;

            margin-bottom: 0.2rem;

            color: #0f172a;
        }

        .worker-id {

            color: #64748b;

            font-size: 0.85rem;

            margin-bottom: 0.7rem;
        }

        /* ================= RATING ================= */

        .worker-rating {

            margin-bottom: 1rem;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 2px;
        }

        .star {

            font-size: 1.1rem;

            color: #cbd5e1;
        }

        .star.filled {

            color: #fbbf24;
        }

        .rating-text {

            margin-left: 6px;

            font-size: 0.9rem;

            font-weight: 600;

            color: #475569;
        }

        /* ================= DETAILS ================= */

        .details {

            width: 100%;

            margin: 0.8rem 0;

            font-size: 0.9rem;

            color: #334155;
        }

        .details p {

            margin: 0.4rem 0;

            display: flex;

            justify-content: space-between;
        }

        .detail-label {

            font-weight: 500;

            color: #475569;
        }

        .detail-value {

            font-weight: 600;
        }

        /* ================= RATE ================= */

        .rate {

            color: #0088dd;

            font-size: 1.2rem;

            font-weight: 700;

            margin: 0.8rem 0;
        }

        /* ================= BUTTON ================= */

        .btn-hire {

            display: inline-block;

            background: #0088dd;

            color: white;

            padding: 0.65rem 2rem;

            border-radius: 2rem;

            text-decoration: none;

            font-weight: 600;

            transition: background 0.2s;

            margin-top: 0.5rem;
        }

        .btn-hire:hover {

            background: #006daa;
        }

        /* ================= EMPTY ================= */

        .no-workers {

            text-align: center;

            color: #64748b;

            font-size: 1.1rem;

            margin-top: 3rem;

            grid-column: 1 / -1;
        }

        /* ================= MOBILE ================= */

        @media (max-width: 400px) {

            body {
                padding: 1.5rem 0.8rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .worker-card {
                max-width: 100%;
            }
        }

    </style>

</head>

<body>

<div class="container">

    <h2>
        🔧 <?= htmlspecialchars($service) ?>s in
        <?= htmlspecialchars($canonicalCity) ?>
    </h2>

    <?php if ($result->num_rows > 0): ?>

        <div class="worker-grid">

        <?php while($worker = $result->fetch_assoc()):

            // Worker image
            $image = !empty($worker['picture'])
                ? 'uploads/' . htmlspecialchars($worker['picture'])
                : 'images/default-worker.png';

            // Worker custom ID
            $workerId = !empty($worker['worker_id'])
                ? htmlspecialchars($worker['worker_id'])
                : 'W' . $worker['id'];

            // Completed orders
            $ordersCompleted = $worker['completed_orders'] ?? 'N/A';

            // Dummy rating
            $rating = rand(3, 5);

        ?>

            <div class="worker-card">

                <!-- IMAGE -->
                <img
                    src="<?= $image ?>"
                    alt="Worker"
                    class="worker-image"
                >

                <!-- NAME -->
                <div class="worker-name">
                    <?= htmlspecialchars($worker['name']) ?>
                </div>

                <!-- ID -->
                <div class="worker-id">
                    ID: <?= $workerId ?>
                </div>

                <!-- ⭐ RATING -->
                <div class="worker-rating">

                    <?php for($i = 1; $i <= 5; $i++): ?>

                        <?php if($i <= $rating): ?>

                            <span class="star filled">★</span>

                        <?php else: ?>

                            <span class="star">☆</span>

                        <?php endif; ?>

                    <?php endfor; ?>

                    <span class="rating-text">
                        <?= $rating ?>.0
                    </span>

                </div>

                <!-- DETAILS -->
                <div class="details">

                    <p>

                        <span class="detail-label">
                            Experience
                        </span>

                        <span class="detail-value">
                            <?= htmlspecialchars($worker['experience_years']) ?> yrs
                        </span>

                    </p>

                    <p>

                        <span class="detail-label">
                            Orders Done
                        </span>

                        <span class="detail-value">
                            <?= htmlspecialchars($ordersCompleted) ?>
                        </span>

                    </p>

                    <p>

                        <span class="detail-label">
                            Availability
                        </span>

                        <span class="detail-value">
                            <?= htmlspecialchars($worker['availability_hours']) ?>h/day
                        </span>

                    </p>

                </div>

                <!-- RATE -->
                <div class="rate">
                    Rs. <?= htmlspecialchars($worker['hourly_rate']) ?>/hr
                </div>

                <!-- HIRE BUTTON -->
                <a
                    href="workpro.php?hire=1&worker_id=<?= $worker['id'] ?>&service=<?= urlencode($service) ?>&city=<?= urlencode($canonicalCity) ?>&time=<?= urlencode($bookingTime) ?>"
                    class="btn-hire"
                >
                    Hire Now
                </a>

            </div>

        <?php endwhile; ?>

        </div>

    <?php else: ?>

        <p class="no-workers">

            No approved
            <?= htmlspecialchars($service) ?>s
            available in
            <?= htmlspecialchars($canonicalCity) ?>
            right now.

        </p>

    <?php endif; ?>

</div>

</body>
</html>