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
            FROM form WHERE userID = ?";

    $stmt = mysqli_prepare($conn, $SQL);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    $BOOKINGS = "SELECT bookingID, room_type, room_number, guests, check_in, check_out, payment, status
                 FROM bookings WHERE userID = ?
                 ORDER BY bookingID DESC";

    $stmt = mysqli_prepare($conn, $BOOKINGS);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $bookings = mysqli_stmt_get_result($stmt);

    // the latest booking that is still Pending or Confirmed
    $current = null;
    $history = [];
    $counts = ['Pending' => 0, 'Confirmed' => 0, 'Completed' => 0, 'Cancelled' => 0];
    while ($row = mysqli_fetch_assoc($bookings)) {
        // the database default is lowercase "pending"
        $row['status'] = empty($row['status']) ? 'Pending' : ucfirst(strtolower($row['status']));
        if ($current == null && ($row['status'] == 'Pending' || $row['status'] == 'Confirmed')) {
            $current = $row;
        }
        if (isset($counts[$row['status']])) {
            $counts[$row['status']]++;
        }
        $history[] = $row;
    }

    $initials = strtoupper(substr($user['firstname'], 0, 1) . substr($user['lastname'], 0, 1));

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UserProfile</title>
        <link rel="stylesheet" href="profile_page.css?v=4">
    </head>
    <body>
        <div class="page">

            <header class="profile-header">
                <div class="avatar"><?php echo htmlspecialchars($initials);?></div>
                <div class="header-text">
                    <h1><?php echo htmlspecialchars($user['firstname'] . " " . $user['lastname']);?></h1>
                    <span><?php echo htmlspecialchars($user['email']);?></span>
                </div>
                <div class="header-actions">
                    <a href="edit_profile.php" class="btn btn-light">Edit Profile</a>
                    <a href="home.php" class="btn btn-outline">Back to Home</a>
                    <a href="logout.php" class="btn btn-logout"
                       onclick="return confirm('Are you sure you want to log out?');">Log Out</a>
                </div>
            </header>

            <?php if (isset($_GET['updated'])): ?>
            <p class="success">Your profile was updated successfully.</p>
            <?php endif; ?>

            <section class="stats">
                <div class="stat">
                    <span class="stat-number"><?php echo count($history);?></span>
                    <span class="stat-label">Total Bookings</span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?php echo $counts['Pending'];?></span>
                    <span class="stat-label">Pending</span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?php echo $counts['Confirmed'];?></span>
                    <span class="stat-label">Confirmed</span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?php echo $counts['Completed'];?></span>
                    <span class="stat-label">Completed</span>
                </div>
            </section>

            <div class="grid">

                <section class="card">
                    <h2>Personal Information</h2>
                    <dl class="details">
                        <div>
                            <dt>First Name</dt>
                            <dd><?php echo htmlspecialchars($user['firstname']);?></dd>
                        </div>
                        <div>
                            <dt>Last Name</dt>
                            <dd><?php echo htmlspecialchars($user['lastname']);?></dd>
                        </div>
                        <div>
                            <dt>Email</dt>
                            <dd><?php echo htmlspecialchars($user['email']);?></dd>
                        </div>
                        <div>
                            <dt>Contact</dt>
                            <dd><?php echo htmlspecialchars($user['contact']);?></dd>
                        </div>
                        <div>
                            <dt>Gender</dt>
                            <dd class="capitalize"><?php echo htmlspecialchars($user['gender']);?></dd>
                        </div>
                    </dl>
                </section>

                <section class="card">
                    <div class="card-title">
                        <h2>Current Booking</h2>
                        <?php if ($current): ?>
                        <span class="status <?php echo strtolower($current['status']);?>">
                        <?php echo htmlspecialchars($current['status']);?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <?php if ($current): ?>
                    <dl class="details">
                        <div>
                            <dt>Booking ID</dt>
                            <dd>#<?php echo htmlspecialchars($current['bookingID']);?></dd>
                        </div>
                        <div>
                            <dt>Room</dt>
                            <dd><?php echo htmlspecialchars($current['room_type']) . " (Room " . htmlspecialchars($current['room_number']) . ")";?></dd>
                        </div>
                        <div>
                            <dt>Guests</dt>
                            <dd><?php echo htmlspecialchars($current['guests']);?></dd>
                        </div>
                        <div>
                            <dt>Check-in</dt>
                            <dd><?php echo htmlspecialchars(date("F j, Y", strtotime($current['check_in'])));?></dd>
                        </div>
                        <div>
                            <dt>Check-out</dt>
                            <dd><?php echo htmlspecialchars(date("F j, Y", strtotime($current['check_out'])));?></dd>
                        </div>
                        <div>
                            <dt>Payment</dt>
                            <dd><?php echo htmlspecialchars($current['payment']);?></dd>
                        </div>
                    </dl>
                    <?php else: ?>
                    <p class="empty">You have no pending or confirmed booking.</p>
                    <?php endif; ?>
                </section>

            </div>

            <section class="card">
                <h2>Booking History</h2>

                <?php if (count($history) > 0): ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Room</th>
                                <th>Guests</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $row): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($row['bookingID']);?></td>
                                <td><?php echo htmlspecialchars($row['room_type']) . " - " . htmlspecialchars($row['room_number']);?></td>
                                <td><?php echo htmlspecialchars($row['guests']);?></td>
                                <td><?php echo htmlspecialchars(date("M j, Y", strtotime($row['check_in'])));?></td>
                                <td><?php echo htmlspecialchars(date("M j, Y", strtotime($row['check_out'])));?></td>
                                <td><?php echo htmlspecialchars($row['payment']);?></td>
                                <td>
                                    <span class="status <?php echo strtolower($row['status']);?>">
                                    <?php echo htmlspecialchars($row['status']);?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="empty">You have no bookings yet.</p>
                <?php endif; ?>
            </section>

        </div>
    </body>
    </html>
