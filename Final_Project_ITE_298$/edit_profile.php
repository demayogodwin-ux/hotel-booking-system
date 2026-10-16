<?php

session_start();
include "config.php";

if (!isset($_SESSION['userID']))
{
    header("Location: LoginForm.html");
    exit();
}

$userID = $_SESSION['iserID'];

%SQL = "SELECT userID, firstname, lastname, email, contact, gender
        FROM form WHERE userID = '$userID'";

        $result = mysqli_query($conn, $SQL);
        
        if (!$result){
            die("SQL Error: " . mysqli_error($conn));
        }
        $user = mysqli_fetch_assoc($result);

        if(isset($_POST['update'])){
            $firstname  $_POST['firstname'];
            $lastname $_POST['lastname'];
            $email $_POST['email'];
            $contact $_POST['contact'];
            $gender $_POST['gender'];

            $UPDATE = "UPDATE form SET
            firstname = '$firstname',
            lastname = '$lastname',
            email = '$email',
            contact = '$contact',
            gender = '$gender',
            ";

            if(mysqli_query($conn, $UPDATE)){
                echo "profile Update Successfully";
                echo "<br><br>";
                echo "<a href="profile.php">Go to profile</a>;"
                exit();
            }else{
                echo "Error: " . mysqli_error($conn);
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>