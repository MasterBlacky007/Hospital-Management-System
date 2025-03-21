<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: plogin.html");
    exit();
}
include "conf.php";

// Retrieve the logged-in patient's details using their email from the session
$email = $_SESSION['email'];
$sql = "SELECT * FROM patientprofile WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

// Close the statement and database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<div class="container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Patient</h1>
            <nav>
                <ul>
                <a href="patientdash.html">Dashboard</a></li>
                <a href="profilepatient.php">My Profile</a>
                <a href="patientapp.php">Book Appointment</a>
                <a href="pappointment.php">View Appointments</a>
                <a href="patientmedi.php">Medical Records</a>
                <a href="viewpbill.php">Payment</a>
                <a href="feedback.php">Feedback</a>
                <a href="plogin.html">Logout</a>
                </ul>
            </nav>
        </div>

    <!-- Main Content -->
    <div class="main-dashboard">
        <h1>Patient's Profile</h1>
        <div class="profile-widget">
            <h2>Personal Information</h2>
            <ul>
                <li><strong>First Name:</strong> <?= htmlspecialchars($patient['firstname']) ?></li>
                <li><strong>Last Name:</strong> <?= htmlspecialchars($patient['lastname']) ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($patient['email']) ?></li>
                <li><strong>Phone:</strong> <?= htmlspecialchars($patient['contact']) ?></li>
                <li><strong>Address:</strong> <?= htmlspecialchars($patient['address']) ?></li>
                <li><strong>Date of Birth:</strong> <?= htmlspecialchars($patient['dob']) ?></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
