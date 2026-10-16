<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingID = $_POST['bookingID'];
    $status = $_POST['status'];
    $SQL = "UPDATE bookings
            SET status = '$status'
            WHERE bookingID = '$bookingID'";
    if (mysqli_query($conn, $SQL)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
?>