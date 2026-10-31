<?php
include "config.php";

if (isset($_POST['submit'])){
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$contact = $_POST['contact'];
$gender = $_POST['gender'];

// stop if the email is already registered
$CHECK = "SELECT userID FROM form WHERE email = ?";
$stmt = mysqli_prepare($conn, $CHECK);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) > 0) {
    header("Location: signup.html?error=email");
    exit();
}

$SQL="INSERT INTO form (firstname, lastname, email, password, contact,  gender)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $SQL);
mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $email, $password, $contact, $gender);

if (mysqli_stmt_execute($stmt)) {
    header("Location: LoginForm.html?signup=1");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
}
?>
