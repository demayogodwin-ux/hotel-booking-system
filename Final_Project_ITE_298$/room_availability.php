<?php

// returns the room numbers that are already booked between check_in and check_out
include "config.php";

header("Content-Type: application/json");

$check_in = isset($_GET['check_in']) ? $_GET['check_in'] : "";
$check_out = isset($_GET['check_out']) ? $_GET['check_out'] : "";

if ($check_in == "" || $check_out == "") {
    echo json_encode([]);
    exit();
}

$SQL = "SELECT DISTINCT room_number FROM bookings
        WHERE LOWER(status) IN ('pending', 'confirmed')
        AND check_in < ? AND check_out > ?";
$stmt = mysqli_prepare($conn, $SQL);
mysqli_stmt_bind_param($stmt, "ss", $check_out, $check_in);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$booked = [];
while ($row = mysqli_fetch_assoc($result)) {
    $booked[] = $row['room_number'];
}

echo json_encode($booked);

?>
