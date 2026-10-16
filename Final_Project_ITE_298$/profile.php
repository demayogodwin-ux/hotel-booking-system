<?php

session_start();

include "config.php";

if (!isset($_SESSION['userID']))
    {
        header("Location: LoginForm.html");
        exit();
    }

    $userID = $_SESSION['userID'];

    $SQL = "SELECT firstname, lastname, email, contact, gender 
            FROM form WHERE userID = '$userID'";

    $result = mysqli_query($conn, $SQL);
    $user = mysqli_fetch_assoc($result);

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UserProfile</title>
        <link rel="stylesheet" href="profile.css">
    </head>
    <body>
        <h1>User profile</h1>

        <p><strong>First Name:</strong>
        <?php echo htmlspecialchars($user['firstname']);?>
        </p>

        <p><strong>Last Name:</strong>
        <?php echo htmlspecialchars($user['lastname']);?>
        </p>

        <p><strong>Email:</strong>
        <?php echo htmlspecialchars($user['email']);?>
        </p>

        <p><strong>Contact:</strong>
        <?php echo htmlspecialchars($user['contact']);?>
        </p>

        <p><strong>Gender:</strong>
        <?php echo htmlspecialchars($user['gender']);?>
        </p>
        <br>

        <a href="home.php">Back to Home</a>

    </body>
    </html>


