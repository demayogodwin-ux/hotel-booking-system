<?php

session_start();
include "config.php";
include "admin_check.php";

// shows a guest's uploaded ID to the admin only
$bookingID = $_GET['id'] ?? '';

$SQL = "SELECT id_file FROM bookings WHERE bookingID = ?";
$stmt = mysqli_prepare($conn, $SQL);
mysqli_stmt_bind_param($stmt, "i", $bookingID);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$path = $row && $row['id_file'] ? __DIR__ . "/uploads/ids/" . basename($row['id_file']) : '';

if (!$path || !is_file($path)){
    http_response_code(404);
    echo "No ID was uploaded for this booking.";
    exit();
}

$mime = (new finfo(FILEINFO_MIME_TYPE))->file($path);
$name = "booking-" . (int)$bookingID . "-id." . pathinfo($path, PATHINFO_EXTENSION);

header("Content-Type: $mime");
header("Content-Length: " . filesize($path));
header("Content-Disposition: inline; filename=\"$name\"");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: private, no-store");
readfile($path);
