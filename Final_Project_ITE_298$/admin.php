<?php
session_start();
include "config.php";
$SQL = "SELECT
    bookings.bookingID,
    bookings.userID,
    form.email,
    form.contact,
    bookings.city,
    bookings.country,
    bookings.guests,
    bookings.room_type,
    bookings.room_number,
    bookings.check_in,
    bookings.check_out,
    bookings.payment,
    bookings.requests,
    bookings.status,
    bookings.booking_date
FROM bookings
INNER JOIN form
ON bookings.userID = form.userID
ORDER BY bookings.bookingID DESC";

$result = mysqli_query($conn, $SQL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="container">
    <h1>Hotel Booking Admin</h1>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>User ID</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Room Type</th>
            <th>Room Number</th>
            <th>Guests</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <tr>
            <td>
                <?php echo $row['bookingID']; ?>
            </td>
            <td>
                <?php echo $row['userID']; ?>
            </td>
            <td>
                <?php echo htmlspecialchars($row['email']); ?>
            </td>
            <td>
                <?php echo htmlspecialchars($row['contact']); ?>
            </td>
            <td>
                <?php echo htmlspecialchars($row['room_type']); ?>
            </td>
            <td>
                <?php echo htmlspecialchars($row['room_number']); ?>
            </td>
            <td>
                <?php echo htmlspecialchars($row['guests']); ?>
            </td>
            <td>
                <?php echo htmlspecialchars($row['check_in']); ?>
            </td>
            <td>
                <?php echo htmlspecialchars($row['check_out']); ?>
            </td>
            <td>
                <?php echo htmlspecialchars($row['payment']); ?>
            </td>

            <td>
                <form action="update_status.php" method="POST">
                    <input
                        type="hidden"
                        name="bookingID"
                        value="<?php echo $row['bookingID']; ?>"
                    >
                    <select
                        name="status"
                        class="status <?php echo strtolower($row['status']); ?>"
                    >
                        <option
                            value="Pending"
                            <?php
                            if ($row['status'] == 'Pending') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Pending
                        </option>

                        <option
                            value="Confirmed"
                            <?php
                            if ($row['status'] == 'Confirmed') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Confirmed
                        </option>

                        <option
                            value="Cancelled"
                            <?php
                            if ($row['status'] == 'Cancelled') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Cancelled
                        </option>

                        <option
                            value="Completed"
                            <?php
                            if ($row['status'] == 'Completed') {
                                echo 'selected';
                            }
                            ?>
                        >
                            Completed
                        </option>
                    </select>

                    <button type="submit">
                        Update
                    </button>
                </form>
            </td>

            <td>
                <a
                    href="delete_booking.php?id=<?php echo $row['bookingID']; ?>"
                    onclick="return confirm('Are you sure you want to delete this booking?');"
                >
                    Delete
                </a>
            </td>
        </tr>
        <?php
            }
        } else {
        ?>
        <tr>
            <td colspan="12">
                No Bookings found.
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
</body>
</html>