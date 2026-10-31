<?php
session_start();
include "config.php";
include "admin_check.php";

// what each status can change to next (same list as admin.php)
$actions = [
    'Pending'   => ['Confirmed', 'Cancelled'],
    'Confirmed' => ['Completed', 'Cancelled'],
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingID = $_POST['bookingID'];
    $status = $_POST['status'];

    // look up the current status first
    $stmt = mysqli_prepare($conn, "SELECT status FROM bookings WHERE bookingID = ?");
    mysqli_stmt_bind_param($stmt, "i", $bookingID);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$row) {
        echo "Booking not found.";
        exit();
    }

    $current = empty($row['status']) ? 'Pending' : ucfirst(strtolower($row['status']));

    if (!in_array($status, $actions[$current] ?? [], true)) {
        echo "A $current booking can't be changed to " . htmlspecialchars($status) . ".";
        exit();
    }

    $SQL = "UPDATE bookings
            SET status = ?
            WHERE bookingID = ?";
    $stmt = mysqli_prepare($conn, $SQL);
    mysqli_stmt_bind_param($stmt, "si", $status, $bookingID);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
?>
