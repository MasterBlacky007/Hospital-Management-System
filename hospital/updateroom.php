<?php
// database connection
include 'conf.php';

// Initialize room variable to store fetched data
$room = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['room_no'])) {
    // Fetch room details by room number when the search form is submitted
    $room_no = $_GET['room_no'];

    // Search query to find the room by room number
    $sql = "SELECT * FROM rooms WHERE room_no = '$room_no'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $room = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Room not found!');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update room data when the update form is submitted
    $room_no = $_POST['room_no'];
    $department = $_POST['department'];
    $room_type = $_POST['room_type'];
    $status = $_POST['status'];

    // Update query to save changes to the room
    $sql = "UPDATE rooms SET 
                department = '$department', 
                room_type = '$room_type', 
                status = '$status' 
            WHERE room_no = '$room_no'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Room updated successfully!');
                window.location.href='updateroom.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating room: " . mysqli_error($conn) . "');
              </script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search and Update Room</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
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
            <h1>Search and Update Room</h1>

            <!-- Search by Room No -->
            <form action="" method="GET" class="search-form">
                <div class="form-row">
                    <label for="search_room_no">Search by Room No:</label>
                    <input type="text" id="search_room_no" name="room_no" placeholder="Enter Room No" required>
                    <button type="submit" class="form-btn">Search</button>
                </div>
            </form>

            <!-- Update Room (Displayed After Search) -->
            <?php if ($room): ?>
            <form action="" method="POST">
                <div class="form-row">
                    <label for="room_no">Room No:</label>
                    <input type="text" id="room_no" name="room_no" value="<?php echo $room['room_no']; ?>" required>
                </div>

                <div class="form-row">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">Select Department</option>
                        <option value="OPD" <?php if ($room['department'] === 'OPD') echo 'selected'; ?>>OPD</option>
                        <option value="ETU" <?php if ($room['department'] === 'ETU') echo 'selected'; ?>>ETU</option>
                        <option value="Dental" <?php if ($room['department'] === 'Dental') echo 'selected'; ?>>Dental</option>
                        <option value="Eye" <?php if ($room['department'] === 'Eye') echo 'selected'; ?>>Eye</option>
                        <option value="Cosmetic Center" <?php if ($room['department'] === 'Cosmetic Center') echo 'selected'; ?>>Cosmetic Center</option>
                        <option value="Inward Room" <?php if ($room['department'] === 'Inward Room') echo 'selected'; ?>>Inward Room</option>
                    </select>
                </div>

                <div class="form-row">
                    <label for="room_type">Room Type:</label>
                    <select id="room_type" name="room_type" required>
                        <option value="">Select Room Type</option>
                        <option value="General" <?php if ($room['room_type'] === 'General') echo 'selected'; ?>>General</option>
                        <option value="Private" <?php if ($room['room_type'] === 'Private') echo 'selected'; ?>>Private</option>
                        <option value="ICU" <?php if ($room['room_type'] === 'ICU') echo 'selected'; ?>>ICU</option>
                    </select>
                </div>

                <div class="form-row status-container">
                    <label for="status">Status:</label>
                    <div class="status-options">
                        <div class="status-option">
                            <input type="radio" id="available" name="status" value="Available" 
                                <?php if ($room['status'] === 'Available') echo 'checked'; ?>>
                            <label for="available">Available</label>
                        </div>
                        <div class="status-option">
                            <input type="radio" id="not_available" name="status" value="Not Available"
                                <?php if ($room['status'] === 'Not Available') echo 'checked'; ?>>
                            <label for="not_available">Not Available</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <button type="submit" class="form-btn">Update Room</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
