<?php

session_start();
include "config.php";
include "admin_check.php";

if (isset($_GET['id'])) {
    $bookingID = $_GET['id'];

    // remember the uploaded ID so it can be removed with the booking
    $stmt = mysqli_prepare($conn, "SELECT id_file FROM bookings WHERE bookingID = ?");
    mysqli_stmt_bind_param($stmt, "i", $bookingID);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    $SQL = "DELETE FROM bookings WHERE bookingID = ?";
    $stmt = mysqli_prepare($conn, $SQL);
    mysqli_stmt_bind_param($stmt, "i", $bookingID);

    if(mysqli_stmt_execute($stmt)) {
        if ($row && $row['id_file']) {
            $path = __DIR__ . "/uploads/ids/" . basename($row['id_file']);
            if (is_file($path)) {
                unlink($path);
            }
        }
        header("Location: admin.php");
        exit();
    }else{
        echo "Error Deleting booking: " . mysqli_error($conn);
    }
    }else{
        echo "No Booking ID found.";
    }
?>
