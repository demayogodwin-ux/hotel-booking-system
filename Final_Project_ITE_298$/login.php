<?php

session_start();

include "config.php";

if (isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $SQL = "SELECT * FROM form WHERE email = ?";
    $stmt = mysqli_prepare($conn, $SQL);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])){
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'];

            if ($user['is_admin'] == 1) {
                header("Location: admin.php");
            } else {
                header("Location: home.php");
            }
            exit();
        }
    }

    header("Location: LoginForm.html?error=1");
    exit();
}

?>