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
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<div class="dashboard">
    <!-- Sidebar -->
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
                </div>
            <h1>MLT</h1>
            <a href="mltdashboard.php">Dashboard</a>
            <a href="profilemlt.php">My Profile</a>
            <a href="lreq.html">Test Requests</a>
            <a href="search.php">View Patient Details</a>
            <a href="labtestdash.php">Lab Test Result</a>
            <a href="labsuprdash.php">Lab Supply Request</a>
            <a href="stlogin.html">Log Out</a>
        </div>


    <!-- Main Content -->
    <div class="main-dashboard">
        <h1>My Profile</h1>
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
