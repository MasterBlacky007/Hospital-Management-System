<?php
// Include the database configuration file
include('conf.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $visitorName = mysqli_real_escape_string($conn, $_POST['visitorName']);
    $nic = mysqli_real_escape_string($conn, $_POST['nic']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    

    // Insert the visitor details into the database
    $query = "INSERT INTO visitors (visitor_name, nic, address, contact, purpose, date) 
              VALUES ('$visitorName', '$nic', '$address', '$contactNo', '$purpose', '$date')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Visitor added successfully!');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Visitor</title>
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
                    <a href="profilerec.php">My Profile</a>
                    <a href="patientRegister.html">Patient Registration</a>
                    <a href="patientprofile.html">Patient Profile</a>
                    <a href="receppatdet.php">Patient Details</a>
                    <a href="appointmentdash.php">Appointment</a>
                    <a href="visitordash.php">Visitors</a></li>
                    <a href="stlogin.html">Logout</a>
        </div>

        <div class="main-content">
            <h2>Visitors</h2>
            <div class="form-container">
                <form method="POST" action="addVisitor.php">
                    <div class="form-row">
                        <label for="visitorName">Visitor Name</label>
                        <input type="text" id="visitorName" name="visitorName" required>
                    </div>
                    <div class="form-row">
                        <label for="nic">NIC</label>
                        <input type="text" id="nic" name="nic" required>
                    </div>
                    <div class="form-row">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="2" required></textarea>
                    </div>
                    <div class="form-row">
                        <label for="contactNo">Contact No</label>
                        <input type="text" id="contactNo" name="contactNo" required>
                    </div>
                    <div class="form-row">
                        <label for="purpose">Purpose</label>
                        <textarea id="purpose" name="purpose" rows="2" required></textarea>
                    </div>
                    <div class="form-row">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-row">
                        <button type="submit" class="form-btn">Submit</button>
                    </div>
                </form>
            <div>
        </div>
    </div>
</body>
</html>
