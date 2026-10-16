<?php
include "config.php";

if (isset($_POST['submit'])){
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$contact = $_POST['contact'];
$gender = $_POST['gender'];

$SQL="INSERT INTO form (firstname, lastname, email, password, contact,  gender)
VALUES ('$firstname', '$lastname', '$email', '$password', '$contact', '$gender')";

if (mysqli_query($conn, $SQL)) {
    header("Location: LoginForm.html");
    exit();
} else {
    echo "Error: " . $SQL . "<br>" . mysqli_error($conn);
}
}  
?>