<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Check if the booking belongs to the current user
    $stmt = $pdo->prepare("SELECT user_id FROM bookings WHERE id = ?");
    $stmt->execute([$id]);
    $booking = $stmt->fetch();

    if ($booking && $booking['user_id'] == $_SESSION['user_id']) {
        // Set cancellation request flag instead of directly cancelling
        $stmt = $pdo->prepare("UPDATE bookings SET cancellation_request = TRUE WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Cancellation request submitted successfully! Admin will review your request.";
    } else {
        $_SESSION['error'] = "You can only cancel your own bookings.";
    }
}

header("Location: my_bookings.php");
exit;
?>