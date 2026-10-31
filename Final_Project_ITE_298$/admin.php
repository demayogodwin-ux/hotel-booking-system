<?php
session_start();
include "config.php";
include "admin_check.php";

$SQL = "SELECT
    bookings.bookingID,
    bookings.userID,
    form.firstname,
    form.lastname,
    form.email,
    form.contact,
    bookings.address,
    bookings.city,
    bookings.country,
    bookings.guests,
    bookings.room_type,
    bookings.room_number,
    bookings.check_in,
    bookings.check_out,
    bookings.payment,
    bookings.requests,
    bookings.id_type,
    bookings.id_number,
    bookings.id_file,
    bookings.status,
    bookings.booking_date
FROM bookings
INNER JOIN form
ON bookings.userID = form.userID
ORDER BY bookings.bookingID DESC";

$result = mysqli_query($conn, $SQL);

$users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM form"));

// same room numbers as the Booking form
$rooms = ['101', '102', '103', '201', '202', '203', '301', '302'];

// what each status can change to next (same list as update_status.php)
$actions = [
    'Pending'   => ['Confirmed' => 'Confirm', 'Cancelled' => 'Cancel'],
    'Confirmed' => ['Completed' => 'Check out', 'Cancelled' => 'Cancel'],
];

$today = date("Y-m-d");
$nextWeek = date("Y-m-d", strtotime("+7 days"));

$bookings = [];
$counts = ['Pending' => 0, 'Confirmed' => 0, 'Completed' => 0, 'Cancelled' => 0];
$checkInsToday = [];
$checkOutsToday = [];
$upcoming = [];
$occupied = [];
$totalGuests = 0;

while ($row = mysqli_fetch_assoc($result)) {
    // the database default is lowercase "pending"
    $row['status'] = empty($row['status']) ? 'Pending' : ucfirst(strtolower($row['status']));
    $row['nights'] = max(0, (strtotime($row['check_out']) - strtotime($row['check_in'])) / 86400);

    if (isset($counts[$row['status']])) {
        $counts[$row['status']]++;
    }

    $active = $row['status'] == 'Pending' || $row['status'] == 'Confirmed';

    if ($active && $row['check_in'] == $today) {
        $checkInsToday[] = $row;
    }
    if ($active && $row['check_out'] == $today) {
        $checkOutsToday[] = $row;
    }
    if ($active && $row['check_in'] > $today && $row['check_in'] <= $nextWeek) {
        $upcoming[] = $row;
    }
    // a confirmed booking whose stay covers today
    if ($row['status'] == 'Confirmed' && $row['check_in'] <= $today && $row['check_out'] > $today) {
        $occupied[$row['room_number']] = $row;
        $totalGuests += (int)$row['guests'];
    }

    $bookings[] = $row;
}

usort($upcoming, function ($a, $b) {
    return strcmp($a['check_in'], $b['check_in']);
});

$occupancy = round(count($occupied) / count($rooms) * 100);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="stylesheet" href="admin.css?v=7">
</head>
<body>

<aside class="sidebar">
    <div class="brand">Hotel Iloilo Admin</div>
    <nav>
        <a href="#overview">Overview</a>
        <a href="#rooms">Rooms</a>
        <a href="#upcoming">Upcoming</a>
        <a href="#bookings">Bookings</a>
        <a href="logout.php" class="logout"
           onclick="return confirm('Are you sure you want to log out?');">Log Out</a>
    </nav>
</aside>

<main class="main">

    <header class="topbar" id="overview">
        <div>
            <h1>Dashboard</h1>
            <span class="date"><?php echo date("l, F j, Y"); ?></span>
        </div>
    </header>

    <!-- stats -->
    <section class="stats">
        <div class="stat">
            <span class="stat-label">Total Bookings</span>
            <span class="stat-number"><?php echo count($bookings); ?></span>
        </div>
        <div class="stat">
            <span class="stat-label">Registered Users</span>
            <span class="stat-number"><?php echo $users['total']; ?></span>
        </div>
        <div class="stat">
            <span class="stat-label">Occupancy Today</span>
            <span class="stat-number"><?php echo $occupancy; ?>%</span>
            <span class="stat-sub"><?php echo count($occupied) . " of " . count($rooms); ?> rooms</span>
        </div>
        <div class="stat">
            <span class="stat-label">Guests In House</span>
            <span class="stat-number"><?php echo $totalGuests; ?></span>
        </div>
        <div class="stat stat-pending">
            <span class="stat-label">Pending</span>
            <span class="stat-number"><?php echo $counts['Pending']; ?></span>
        </div>
        <div class="stat stat-confirmed">
            <span class="stat-label">Confirmed</span>
            <span class="stat-number"><?php echo $counts['Confirmed']; ?></span>
        </div>
        <div class="stat stat-completed">
            <span class="stat-label">Completed</span>
            <span class="stat-number"><?php echo $counts['Completed']; ?></span>
        </div>
        <div class="stat stat-cancelled">
            <span class="stat-label">Cancelled</span>
            <span class="stat-number"><?php echo $counts['Cancelled']; ?></span>
        </div>
    </section>

    <div class="grid">

        <!-- today -->
        <section class="card">
            <h2>Today's Activity</h2>

            <h3>Check-ins (<?php echo count($checkInsToday); ?>)</h3>
            <?php if (count($checkInsToday) > 0): ?>
            <ul class="list">
                <?php foreach ($checkInsToday as $row): ?>
                <li>
                    <span><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></span>
                    <span class="muted">Room <?php echo htmlspecialchars($row['room_number']); ?></span>
                    <span class="badge <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="empty">No check-ins today.</p>
            <?php endif; ?>

            <h3>Check-outs (<?php echo count($checkOutsToday); ?>)</h3>
            <?php if (count($checkOutsToday) > 0): ?>
            <ul class="list">
                <?php foreach ($checkOutsToday as $row): ?>
                <li>
                    <span><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></span>
                    <span class="muted">Room <?php echo htmlspecialchars($row['room_number']); ?></span>
                    <span class="badge <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="empty">No check-outs today.</p>
            <?php endif; ?>
        </section>

        <!-- rooms -->
        <section class="card" id="rooms">
            <h2>Room Status Today</h2>
            <div class="rooms">
                <?php foreach ($rooms as $room): ?>
                    <?php if (isset($occupied[$room])): ?>
                    <div class="room occupied">
                        <span class="room-number"><?php echo $room; ?></span>
                        <span class="room-state">Occupied</span>
                        <span class="room-guest"><?php echo htmlspecialchars($occupied[$room]['firstname']); ?></span>
                    </div>
                    <?php else: ?>
                    <div class="room available">
                        <span class="room-number"><?php echo $room; ?></span>
                        <span class="room-state">Available</span>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>

    </div>

    <!-- upcoming -->
    <section class="card" id="upcoming">
        <h2>Upcoming Check-ins (Next 7 Days)</h2>
        <?php if (count($upcoming) > 0): ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Guests</th>
                        <th>Nights</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($upcoming as $row): ?>
                    <tr>
                        <td><?php echo date("M j, Y", strtotime($row['check_in'])); ?></td>
                        <td><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row['room_type'] . " - " . $row['room_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['guests']); ?></td>
                        <td><?php echo $row['nights']; ?></td>
                        <td><span class="badge <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="empty">No check-ins in the next 7 days.</p>
        <?php endif; ?>
    </section>

    <!-- all bookings -->
    <section class="card" id="bookings">
        <div class="card-head">
            <h2>All Bookings</h2>
            <div class="tools">
                <input type="text" id="search" placeholder="Search guest, email, room...">
                <select id="filter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="table-wrap">
            <table id="bookingTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Guest</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Room</th>
                        <th>Guests</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Nights</th>
                        <th>Payment</th>
                        <th>Valid ID</th>
                        <th>Requests</th>
                        <th>Booked On</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($bookings) > 0): ?>
                    <?php foreach ($bookings as $row): ?>
                    <tr data-status="<?php echo strtolower($row['status']); ?>">
                        <td>#<?php echo $row['bookingID']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></strong>
                            <span class="muted block"><?php echo htmlspecialchars($row['email']); ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($row['contact']); ?></td>
                        <td class="wrap"><?php echo htmlspecialchars($row['address'] . ", " . $row['city'] . ", " . $row['country']); ?></td>
                        <td>
                            <?php echo htmlspecialchars($row['room_type']); ?>
                            <span class="muted block">Room <?php echo htmlspecialchars($row['room_number']); ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($row['guests']); ?></td>
                        <td><?php echo date("M j, Y", strtotime($row['check_in'])); ?></td>
                        <td><?php echo date("M j, Y", strtotime($row['check_out'])); ?></td>
                        <td><?php echo $row['nights']; ?></td>
                        <td><?php echo htmlspecialchars($row['payment']); ?></td>
                        <td>
                            <?php if ($row['id_file']): ?>
                            <?php echo htmlspecialchars($row['id_type']); ?>
                            <span class="muted block">••••<?php echo htmlspecialchars(substr($row['id_number'], -4)); ?></span>
                            <a href="view_id.php?id=<?php echo $row['bookingID']; ?>" target="_blank" rel="noopener" class="view-id">View ID</a>
                            <?php else: ?>
                            <span class="muted">No ID</span>
                            <?php endif; ?>
                        </td>
                        <td class="wrap"><?php echo $row['requests'] != '' ? htmlspecialchars($row['requests']) : '<span class="muted">None</span>'; ?></td>
                        <td><?php echo $row['booking_date'] ? date("M j, Y", strtotime($row['booking_date'])) : '-'; ?></td>
                        <td><span class="badge <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span></td>
                        <td>
                            <div class="row-actions">
                                <?php foreach ($actions[$row['status']] ?? [] as $next => $label): ?>
                                <form
                                    action="update_status.php"
                                    method="POST"
                                    <?php if ($next == 'Cancelled'): ?>onsubmit="return confirm('Cancel booking #<?php echo $row['bookingID']; ?>? This can\'t be undone.');"<?php endif; ?>
                                >
                                    <input type="hidden" name="bookingID" value="<?php echo $row['bookingID']; ?>">
                                    <input type="hidden" name="status" value="<?php echo $next; ?>">
                                    <button type="submit" class="action <?php echo $next == 'Cancelled' ? 'action-cancel' : 'action-main'; ?>"><?php echo $label; ?></button>
                                </form>
                                <?php endforeach; ?>
                                <a
                                    href="delete_booking.php?id=<?php echo $row['bookingID']; ?>"
                                    class="delete"
                                    onclick="return confirm('Are you sure you want to delete this booking?');"
                                >
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <tr id="noResults" <?php if (count($bookings) > 0) echo 'style="display:none"'; ?>>
                        <td colspan="15" class="empty">No Bookings found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</main>

<script>
    const search = document.getElementById("search");
    const filter = document.getElementById("filter");
    const rows = document.querySelectorAll("#bookingTable tbody tr[data-status]");
    const noResults = document.getElementById("noResults");

    function filterBookings() {
        const text = search.value.toLowerCase();
        const status = filter.value;
        let shown = 0;

        rows.forEach(row => {
            const matchText = row.textContent.toLowerCase().includes(text);
            const matchStatus = status == "" || row.dataset.status == status;
            row.style.display = matchText && matchStatus ? "" : "none";
            if (matchText && matchStatus) shown++;
        });

        noResults.style.display = shown == 0 ? "" : "none";
    }

    search.addEventListener("input", filterBookings);
    filter.addEventListener("change", filterBookings);
</script>

</body>
</html>
