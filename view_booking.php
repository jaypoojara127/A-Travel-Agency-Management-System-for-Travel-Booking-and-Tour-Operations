<?php
require 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Get booking details (updated query without email)
$stmt = $pdo->prepare("
    SELECT b.*, u.username, t.name as tour_name, t.location, t.price, t.image_url, t.duration
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN tours t ON b.tour_id = t.id
    WHERE b.id = ?
");
$stmt->execute([$_GET['id']]);
$booking = $stmt->fetch();

if (!$booking) {
    header("Location: bookings.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Details</title>
    <link rel="stylesheet" href="style.css">
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
        <h2>Booking Details #<?= $booking['id'] ?></h2>
        
        <div class="booking-details">
            <div class="detail-card">
                <h3>User Information</h3>
                <p><strong>Username:</strong> <?= htmlspecialchars($booking['username']) ?></p>
            </div>
            
            <div class="detail-card">
                <h3>Tour Information</h3>
                <div class="tour-img" style="background-image: url('<?= htmlspecialchars($booking['image_url']) ?>')"></div>
                <p><strong>Tour:</strong> <?= htmlspecialchars($booking['tour_name']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($booking['location']) ?></p>
                <p><strong>Duration:</strong> <?= htmlspecialchars($booking['duration']) ?></p>
                <p><strong>Price per person:</strong> $<?= number_format($booking['price'], 2) ?></p>
            </div>
            
            <div class="detail-card">
                <h3>Booking Information</h3>
                <p><strong>Booking Date:</strong> <?= date('F j, Y', strtotime($booking['booking_date'])) ?></p>
                <p><strong>Participants:</strong> <?= htmlspecialchars($booking['participants']) ?></p>
                <?php if (!empty($booking['special_requests'])): ?>
                    <p><strong>Special Requests:</strong> <?= htmlspecialchars($booking['special_requests']) ?></p>
                <?php endif; ?>
            </div>
            
            <div class="detail-card">
                <h3>Status & Payment</h3>
                <p><strong>Status:</strong> <span class="status-<?= $booking['status'] ?>">
                    <?= ucfirst($booking['status']) ?>
                </span></p>
                <p><strong>Total Price:</strong> $<?= number_format($booking['total_price'], 2) ?></p>
                <p><strong>Booked on:</strong> <?= date('F j, Y g:i a', strtotime($booking['created_at'])) ?></p>
            </div>
        </div>
        
        <div class="actions">
            <a href="bookings.php" class="btn">Back to Bookings</a>
            <?php if ($booking['status'] != 'cancelled'): ?>
                <a href="cancel_booking.php?id=<?= $booking['id'] ?>" class="btn btn-danger">Cancel Booking</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>