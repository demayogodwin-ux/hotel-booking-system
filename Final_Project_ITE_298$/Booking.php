<?php

session_start();
include "config.php";

if (!isset($_SESSION['userID'])){
    header("Location: LoginForm.html");
    exit();
}

if (!isset($_POST['submit'])){
    header("Location: Booking.html");
    exit();
}

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

if ($check_in < date("Y-m-d")){
    header("Location: Booking.html?error=past");
    exit();
}

if (strtotime($check_out) <= strtotime($check_in)){
    header("Location: Booking.html?error=dates");
    exit();
}

// valid ID checks
function backToForm($error){
    header("Location: Booking.html?error=$error");
    exit();
}

$id_types = ["PhilSys National ID", "Passport", "Driver's License", "UMID",
             "SSS ID", "PRC ID", "Postal ID", "Voter's ID"];
$id_type = $_POST['id_type'] ?? '';
$id_number = strtoupper(trim($_POST['id_number'] ?? ''));
$file = $_FILES['id_file'] ?? null;

if (!in_array($id_type, $id_types, true)){
    backToForm("id_type");
}

if (!preg_match('/^[A-Z0-9-]{5,25}$/', $id_number)){
    backToForm("id_number");
}

if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE){
    backToForm("id_file");
}

if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['size'] > 5 * 1024 * 1024){
    backToForm("id_size");
}

if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])){
    backToForm("id_upload");
}

// look at what the file really contains, not just its name
$allowed = ["image/jpeg" => "jpg", "image/png" => "png", "application/pdf" => "pdf"];
$mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);

if (!isset($allowed[$mime])){
    backToForm("id_format");
}

if ($mime !== "application/pdf" && getimagesize($file['tmp_name']) === false){
    backToForm("id_format");
}

// stop if the room already has a pending or confirmed booking on these dates
$CHECK = "SELECT bookingID FROM bookings
          WHERE room_number = ?
          AND LOWER(status) IN ('pending', 'confirmed')
          AND check_in < ? AND check_out > ?";
$stmt = mysqli_prepare($conn, $CHECK);
mysqli_stmt_bind_param($stmt, "sss", $room_number, $check_out, $check_in);
mysqli_stmt_execute($stmt);

if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) > 0){
    header("Location: Booking.html?error=taken");
    exit();
}

// save the ID with a random name in a folder that can't be opened from the browser
$upload_dir = __DIR__ . "/uploads/ids/";
if (!is_dir($upload_dir)){
    mkdir($upload_dir, 0755, true);
}

$id_file = bin2hex(random_bytes(16)) . "." . $allowed[$mime];

if (!move_uploaded_file($file['tmp_name'], $upload_dir . $id_file)){
    backToForm("id_upload");
}

$SQL = "INSERT INTO bookings
(userID, address, city, country, guests, room_type, room_number, check_in, check_out, payment, requests, id_type, id_number, id_file)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $SQL);
mysqli_stmt_bind_param($stmt, "isssssssssssss",
    $userID, $address, $city, $country, $guests, $room_type,
    $room_number, $check_in, $check_out, $payment, $requests,
    $id_type, $id_number, $id_file);

if (!mysqli_stmt_execute($stmt)){
    unlink($upload_dir . $id_file);
    echo "Error: " . mysqli_error($conn);
    exit();
}

$bookingID = mysqli_insert_id($conn);
$nights = (strtotime($check_out) - strtotime($check_in)) / 86400;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css">
    <link rel="stylesheet" href="booking_success.css?v=2">
</head>
<body>
    <div class="card">
        <div class="check"><i class="fa-solid fa-check"></i></div>
        <h1>Booking Successful!</h1>
        <p class="note">Thank you! Your booking is now <span class="badge">Pending</span> until our staff confirms it.</p>

        <dl class="details">
            <div>
                <dt>Booking ID</dt>
                <dd>#<?php echo htmlspecialchars($bookingID);?></dd>
            </div>
            <div>
                <dt>Room</dt>
                <dd><?php echo htmlspecialchars($room_type) . " (Room " . htmlspecialchars($room_number) . ")";?></dd>
            </div>
            <div>
                <dt>Guests</dt>
                <dd><?php echo htmlspecialchars($guests);?></dd>
            </div>
            <div>
                <dt>Check-in</dt>
                <dd><?php echo htmlspecialchars(date("F j, Y", strtotime($check_in)));?></dd>
            </div>
            <div>
                <dt>Check-out</dt>
                <dd><?php echo htmlspecialchars(date("F j, Y", strtotime($check_out)));?></dd>
            </div>
            <div>
                <dt>Nights</dt>
                <dd><?php echo $nights;?></dd>
            </div>
            <div>
                <dt>Address</dt>
                <dd><?php echo htmlspecialchars("$address, $city, $country");?></dd>
            </div>
            <div>
                <dt>Payment</dt>
                <dd><?php echo htmlspecialchars($payment);?></dd>
            </div>
            <div>
                <dt>Valid ID</dt>
                <dd><?php echo htmlspecialchars($id_type) . " &middot; ••••" . htmlspecialchars(substr($id_number, -4));?></dd>
            </div>
            <?php if (!empty($requests)): ?>
            <div>
                <dt>Requests</dt>
                <dd><?php echo htmlspecialchars($requests);?></dd>
            </div>
            <?php endif; ?>
        </dl>

        <div class="buttons">
            <a href="profile.php" class="btn btn-primary">View My Bookings</a>
            <a href="Home.php" class="btn btn-outline">Back to Home</a>
        </div>
    </div>
</body>
</html>
