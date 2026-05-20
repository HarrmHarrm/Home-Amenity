<?php
include("../includes/db.php");

$sql = "SELECT * FROM chat_rooms ORDER BY id DESC";
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("Query failed: " . $conn->error);
}

$totalRooms = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Chats</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        a {
            background: #0084ff;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .info {
            margin-bottom: 15px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>

<h2>All Chat Rooms</h2>
<p class="info">Total rooms found: <?php echo $totalRooms; ?></p>

<?php if ($totalRooms > 0): ?>
    <table>
        <tr>
            <th>Room ID</th>
            <th>Customer ID</th>
            <th>Worker ID</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['customer_id']); ?></td>
                <td><?php echo htmlspecialchars($row['worker_id']); ?></td>
                <td>
                    <a href="view_chat.php?room_id=<?php echo urlencode($row['id']); ?>">
                        Open Chat
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No chat rooms exist yet.</p>
<?php endif; ?>

</body>
</html>