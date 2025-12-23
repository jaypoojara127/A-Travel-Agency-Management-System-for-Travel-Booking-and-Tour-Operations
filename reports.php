<?php
require 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Get report data
$revenue = $pdo->query("
    SELECT 
        SUM(b.total_price) as total_revenue,
        COUNT(*) as total_bookings,
        AVG(b.total_price) as avg_booking_value
    FROM bookings b
    WHERE b.status = 'confirmed'
")->fetch();

$popular_tours = $pdo->query("
    SELECT t.name, COUNT(b.id) as bookings_count
    FROM tours t
    LEFT JOIN bookings b ON t.id = b.tour_id
    GROUP BY t.id
    ORDER BY bookings_count DESC
    LIMIT 5
")->fetchAll();

$monthly_revenue = $pdo->query("
    SELECT 
        DATE_FORMAT(b.created_at, '%Y-%m') as month,
        SUM(b.total_price) as revenue
    FROM bookings b
    WHERE b.status = 'confirmed'
    GROUP BY month
    ORDER BY month DESC
    LIMIT 6
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Reports</title>
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
        <h2>System Reports</h2>
        
        <div class="grid">
            <!-- Revenue Summary -->
            <div class="card">
                <h3>Revenue Summary</h3>
                <div class="stats">
                    <p>Total Revenue: <strong>$<?= number_format($revenue['total_revenue'] ?? 0, 2) ?></strong></p>
                    <p>Total Bookings: <strong><?= $revenue['total_bookings'] ?? 0 ?></strong></p>
                    <p>Avg. Booking Value: <strong>$<?= number_format($revenue['avg_booking_value'] ?? 0, 2) ?></strong></p>
                </div>
            </div>
            
            <!-- Popular Tours -->
            <div class="card">
                <h3>Popular Tours</h3>
                <ul>
                    <?php foreach ($popular_tours as $tour): ?>
                    <li>
                        <?= htmlspecialchars($tour['name']) ?>
                        <span class="badge"><?= $tour['bookings_count'] ?> bookings</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Monthly Revenue -->
            <div class="card">
                <h3>Monthly Revenue</h3>
                <table>
                    <tr>
                        <th>Month</th>
                        <th>Revenue</th>
                    </tr>
                    <?php foreach ($monthly_revenue as $month): ?>
                    <tr>
                        <td><?= date('F Y', strtotime($month['month'] . '-01')) ?></td>
                        <td>$<?= number_format($month['revenue'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>