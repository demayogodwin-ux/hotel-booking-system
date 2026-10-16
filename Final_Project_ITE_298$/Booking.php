<?php

session_start();
include "config.php";

if (!isset($_SESSION['userID'])){
    header("Location: LoginForm.html");
    exit();
}

if (isset($_POST['submit'])){
    $userID = $_SESSION['userID'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $guests = $_POST['guests'];
    $room_type = $_POST['room_type'];
    $room_number = $_POST['room_number'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $payment = $_POST['payment'];
    $requests = $_POST['requests'];
    $SQL = "INSERT INTO bookings 
    (userID, address, city, country, guests, room_type, room_number, check_in, check_out, payment, requests)
    VALUE ('$userID', '$address', '$city', '$country', '$guests', '$room_type', '$room_number', '$check_in', '$check_out', '$payment', '$requests')";

    if (mysqli_query($conn, $SQL)){
        echo "Booking Successful!";
    }else{
        echo "Error: " . mysqli_error($conn);
    }

}

?>