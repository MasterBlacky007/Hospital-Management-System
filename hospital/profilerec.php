<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
include "conf.php";

$staff_id = $_SESSION['user_id'];
$sql = "SELECT * FROM staff WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();
$staff = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="dashboard1.css">
</head>
<body>
<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="logo.jpeg" alt="Hospital Logo">
            <h2>Apollo Hospital</h2>
        </div>
        <nav>
            <h1><center>Receptionist</center></h1>
            <ul>
                    <a href="receptionistdashboard.html">Dashboard</a>
                    <a href="profilerec.php">My Profile</a>
                    <a href="patientRegister.html">Patient Registration</a>
                    <a href="patientprofile.html">Patient Profile</a>
                    <a href="receppatdet.php">Patient Details</a>
                    <a href="appointmentdash.php">Appointment</a>
                    <a href="visitordash.php">Visitors</a></li>
                    <a href="stlogin.html">Logout</a>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-dashboard">
        <h1>Doctor's Profile</h1>
        <div class="profile-widget">
            <h2>Personal Information</h2>
            <ul>
                <li><strong>Name:</strong> <?= htmlspecialchars($staff['name']) ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($staff['email']) ?></li>
                <li><strong>Specialization:</strong> <?= htmlspecialchars($staff['additionalNotes']) ?></li>
                <li><strong>Phone:</strong> <?= htmlspecialchars($staff['phone']) ?></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>