<?php
// Include the database configuration file
include('conf.php');

// Initialize variables for visitor data
$visitor = [];
$contactNo = "";

// Fetch visitor details if contact number is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Searching for a visitor
    if (isset($_POST['search'])) {
        $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
        $searchQuery = "SELECT * FROM visitors WHERE contact = '$contactNo'";
        $result = mysqli_query($conn, $searchQuery);

        if ($result && mysqli_num_rows($result) > 0) {
            $visitor = mysqli_fetch_assoc($result);
        } else {
            echo "<script>alert('No visitor found with this contact number!');</script>";
        }
    }

    // Updating visitor details
    if (isset($_POST['update'])) {
        $visitorName = mysqli_real_escape_string($conn, $_POST['visitorName']);
        $nic = mysqli_real_escape_string($conn, $_POST['nic']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
        $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);

        $updateQuery = "UPDATE visitors 
                        SET visitor_name = '$visitorName', 
                            nic = '$nic', 
                            address = '$address', 
                            purpose = '$purpose', 
                            date = '$date'
                        WHERE contact = '$contactNo'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Visitor details updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating visitor details: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Visitor</title>
    <link rel="stylesheet" href="dashboard1.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Receptionist</h1>
            <a href="receptionistdashboard.html">Dashboard</a>
                    <a href="receptionistdashboard.html">Dashboard</a>
                    <a href="profilerec.php">My Profile</a>
                    <a href="patientRegister.html">Patient Registration</a>
                    <a href="patientprofile.html">Patient Profile</a>
                    <a href="receppatdet.php">Patient Details</a>
                    <a href="appointmentdash.php">Appointment</a>
                    <a href="visitordash.php">Visitors</a></li>
                    <a href="stlogin.html">Logout</a>
        </div>

        <div class="main-content">
            <h2>Update Visitor</h2>
            <div class="form-container">
                <form method="POST" action="updatevisitor.php">
                    <!-- Search Section -->
                    <div class="form-row">
                        <label for="contactNo">Contact No</label>
                        <input type="text" id="contactNo" name="contactNo" required value="<?= isset($visitor['contact']) ? $visitor['contact'] : '' ?>">
                    </div>
                    <div class="form-row">
                        <button type="submit" name="search" class="form-btn">Search Visitor</button>
                    </div>

                    <?php if (!empty($visitor)): ?>
                        <hr>
                        <!-- Visitor Details -->
                        <div class="form-row">
                            <label for="visitorName">Visitor Name</label>
                            <input type="text" id="visitorName" name="visitorName" required value="<?= $visitor['visitor_name'] ?>">
                        </div>
                        <div class="form-row">
                            <label for="nic">NIC</label>
                            <input type="text" id="nic" name="nic" required value="<?= $visitor['nic'] ?>">
                        </div>
                        <div class="form-row">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="2" required><?= $visitor['address'] ?></textarea>
                        </div>
                        <div class="form-row">
                            <label for="purpose">Purpose</label>
                            <textarea id="purpose" name="purpose" rows="2" required><?= $visitor['purpose'] ?></textarea>
                        </div>
                        <div class="form-row">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" required value="<?= $visitor['date'] ?>">
                        </div>
                        <div class="form-row">
                            <button type="submit" name="update" class="form-btn">Update Visitor</button>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
