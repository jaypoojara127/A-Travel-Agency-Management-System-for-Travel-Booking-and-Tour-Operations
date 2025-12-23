<?php
require 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    if ($action == 'approve') {
        // Approve cancellation: set status to cancelled and reset cancellation_request
        $stmt = $pdo->prepare("UPDATE bookings SET status = 'cancelled', cancellation_request = FALSE WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Cancellation request approved successfully!";
    } elseif ($action == 'reject') {
        // Reject cancellation: just reset the cancellation_request flag
        $stmt = $pdo->prepare("UPDATE bookings SET cancellation_request = FALSE WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Cancellation request rejected successfully!";
    }
}

header("Location: bookings.php");
exit;
?>