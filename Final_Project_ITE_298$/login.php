<?php

session_start();

include "config.php";

if (isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $SQL = "SELECT * FROM form WHERE email = '$email'";
    $result = mysqli_query($conn, $SQL);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])){
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['email'] = $user['email'];

            header("Location: home.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Email not found.";
    }
}

?>