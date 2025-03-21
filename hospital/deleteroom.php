<?php

include('conf.php');

// Initialize variables
$roomData = [];
$errorMessage = "";

// Step 1: Load Room Details
if (isset($_POST['load_details'])) {
    // Get the room number from the form
    $room_no = mysqli_real_escape_string($conn, $_POST['room_no']);

    // Query to fetch the room details
    $query = "SELECT * FROM rooms WHERE room_no = '$room_no'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch room details
        $roomData = mysqli_fetch_assoc($result);
    } else {
        $errorMessage = "No room found with this room number!";
    }
}

// Step 2: Delete Room
if (isset($_POST['delete_room'])) {
    $room_no = mysqli_real_escape_string($conn, $_POST['room_no']);

    // Query to delete the room
    $deleteQuery = "DELETE FROM rooms WHERE room_no = '$room_no'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>
            alert('Room deleted successfully!');
            window.location.href = 'roomdash.php'; 
        </script>";
        exit;
    } else {
        echo "Error deleting room: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Room</title>
    <link rel="stylesheet" href="style.css">

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this room?');
        }
    </script>
</head>
<body>
    <div class="form-container">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Nurse</h1>
            <nav>
            <a href="nursedashboard.html">Dashboard</a>
                <a href="nursepatient.php">Patient Profile</a>
                <a href="roomdash.php">Room</a>
                <a href="admissiondash.php">Admission</a>
                <a href="mytask.php">My Task</a>
                <a href="viewlabtest.php">View Lab Test Results</a>
                <a href="pres_view.php">View Prescription</a>
                <a href="vitalsigndash.php">Vital Sign</a>
                <a href="progressdash.php">Progress Notes</a>
                <a href="stlogin.html">Logout</a>
            </nav>
        </div>
        <div class="main-content">
            <h1>Delete Room</h1>
            <form action="deleteroom.php" method="POST">
                <div class="form-row">
                    <label for="room_no">Enter Room No:</label>
                    <input type="text" id="room_no" name="room_no" required>
                </div>
                <div class="form-row">
                    <button type="submit" name="load_details" class="form-btn">Load Details</button>
                </div>
            </form>

            <?php if (!empty($roomData)): ?>
                <h3>Room Details</h3>
                <p><strong>Room No:</strong> <?= $roomData['room_no'] ?></p>
                <p><strong>Department:</strong> <?= $roomData['department'] ?></p>
                <p><strong>Room Type:</strong> <?= $roomData['room_type'] ?></p>
                <p><strong>Status:</strong> <?= $roomData['status'] ?></p>

                <form action="deleteroom.php" method="POST" onsubmit="return confirmDelete();">
                    <input type="hidden" name="room_no" value="<?= $roomData['room_no'] ?>">
                    <button type="submit" name="delete_room" class="form-btn">Delete Room</button>
                </form>
            <?php endif; ?>

            <?php if (!empty($errorMessage)): ?>
                <p class="error-message"><?= $errorMessage ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
