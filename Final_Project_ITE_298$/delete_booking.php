<?php

include "config.php";

if (isset($_GET['id'])) {
    $bookingID = $_GET['id'];
    $SQL = "DELETE FROM bookings WHERE bookingID = '$bookingID'";

    if(mysqli_query($conn, $SQL)) {
        header("Location: admin.php");
        exit();
    }else{
        echo "Error Deleting booking: " . mysqli_error($conn);
    }
    }else{
        echo "No Booking ID found.";
    }
?>