<?php

session_start();
include "config.php";

if (!isset($_SESSION['userID']))
{
    header("Location: LoginForm.html");
    exit();
}

$userID = $_SESSION['userID'];

$SQL = "SELECT userID, firstname, lastname, email, contact, gender
        FROM form WHERE userID = ?";

        $stmt = mysqli_prepare($conn, $SQL);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result){
            die("SQL Error: " . mysqli_error($conn));
        }
        $user = mysqli_fetch_assoc($result);

        $error = "";

        if(isset($_POST['update'])){
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $contact = $_POST['contact'];
            $gender = $_POST['gender'];

            // the new email must not belong to another user
            $CHECK = "SELECT userID FROM form WHERE email = ? AND userID != ?";
            $stmt = mysqli_prepare($conn, $CHECK);
            mysqli_stmt_bind_param($stmt, "si", $email, $userID);
            mysqli_stmt_execute($stmt);

            if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) > 0) {
                $error = "That email is already used by another account.";
                $user = ['firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'contact' => $contact, 'gender' => $gender];
            } else {
                $UPDATE = "UPDATE form SET
                firstname = ?,
                lastname = ?,
                email = ?,
                contact = ?,
                gender = ?
                WHERE userID = ?";

                $stmt = mysqli_prepare($conn, $UPDATE);
                mysqli_stmt_bind_param($stmt, "sssssi", $firstname, $lastname, $email, $contact, $gender, $userID);

                if(mysqli_stmt_execute($stmt)){
                    $_SESSION['email'] = $email;
                    header("Location: profile.php?updated=1");
                    exit();
                }else{
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="signup.css?v=3">
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <?php if ($error != ""): ?>
        <p class="error"><?php echo $error;?></p>
        <?php endif; ?>
        <form action="edit_profile.php" method="post">
            <label for="firstname">FirstName:</label>
            <input type="text" id="firstname" name="firstname" required
            value="<?php echo htmlspecialchars($user['firstname']);?>">

            <label for="lastname">LastName:</label>
            <input type="text" id="lastname" name="lastname" required
            value="<?php echo htmlspecialchars($user['lastname']);?>">

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required
            value="<?php echo htmlspecialchars($user['email']);?>">

            <label for="contact">Contact Number:</label>
            <input type="tel" id="contact" name="contact" required
            value="<?php echo htmlspecialchars($user['contact']);?>">

            <label for="gender">Select Gender:</label>
            <input type="radio" name="gender" id="male" value="male" required
            <?php if ($user['gender'] == 'male') echo 'checked';?>> Male
            <input type="radio" name="gender" id="female" value="female" required
            <?php if ($user['gender'] == 'female') echo 'checked';?>> Female

            <button type="submit" name="update">Update Profile</button>
            <p><a href="profile.php">Back to Profile</a></p>
        </form>
    </div>
</body>
</html>