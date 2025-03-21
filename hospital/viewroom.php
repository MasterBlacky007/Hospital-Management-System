<?php
// Include database connection
include 'conf.php';

// Query to fetch all rooms
$sql = "SELECT * FROM rooms";
$result = mysqli_query($conn, $sql);

// Query to count the total number of rooms
$count_sql = "SELECT COUNT(*) AS total_rooms FROM rooms";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_rooms = $count_row['total_rooms'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rooms</title>
    <link rel="stylesheet" href="viewtable.css">
</head>
<body>
    <div class="container">
    <h3>Room List</h3>
        <button class="add-patient" onclick="window.location.href='room.php'">+ Add Room</button>
        <button class="back" onclick="window.location.href='roomdash.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        

        <div class="main-content">
           
            <!-- Total Rooms Count -->
            <div class="total-rooms">
                <h2>Total Rooms: <?php echo $total_rooms; ?></h2>
            </div>

            <!-- Rooms Table -->
            <table id="rooms-table">
                <thead>
                    <tr>
                        <th>Room No</th>
                        <th>Department</th>
                        <th>Room Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Loop through and display each room
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['room_no'] . "</td>";
                            echo "<td>" . $row['department'] . "</td>";
                            echo "<td>" . $row['room_type'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No rooms available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
