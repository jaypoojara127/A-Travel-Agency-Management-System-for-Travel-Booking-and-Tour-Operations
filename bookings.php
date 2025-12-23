<?php
require 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $id = (int)$_POST['booking_id'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    
    $_SESSION['success'] = "Booking status updated successfully!";
    header("Location: bookings.php");
    exit;
}

// Get all bookings with user and tour info
$bookings = $pdo->query("
    SELECT b.*, u.username, t.name as tour_name, t.price, t.duration
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN tours t ON b.tour_id = t.id
    ORDER BY b.created_at DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function updateStatus(bookingId) {
        const form = document.getElementById('status-form-' + bookingId);
        const formData = new FormData(form);
        
        fetch('update_status.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
    }
    </script>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">Tour Management</div>
            <nav>
                <ul>
                    <li><a href="admin_panel.php">Dashboard</a></li>
                    <li><a href="users.php">Manage Users</a></li>
                    <li><a href="tours.php">Manage Tours</a></li>
                    <li><a href="bookings.php">View Bookings</a></li>
                    <li><a href="reports.php">View Reports</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>All Bookings</h2>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Tour</th>
                        <th>Booking Date</th>
                        <th>Participants</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Booked On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= $booking['id'] ?></td>
                        <td><?= htmlspecialchars($booking['username']) ?></td>
                        <td><?= htmlspecialchars($booking['tour_name']) ?></td>
                        <td><?= date('M j, Y', strtotime($booking['booking_date'])) ?></td>
                        <td><?= htmlspecialchars($booking['participants']) ?></td>
                        <td>$<?= number_format($booking['total_price'], 2) ?></td>
                        <td>
                            <form id="status-form-<?= $booking['id'] ?>" method="POST">
                                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                <select name="status" onchange="updateStatus(<?= $booking['id'] ?>)">
                                    <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                    <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td><?= date('M j, Y', strtotime($booking['created_at'])) ?></td>
                        <td>
                            <a href="view_booking.php?id=<?= $booking['id'] ?>" class="btn">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>