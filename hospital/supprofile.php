<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: suplogin.html");
    exit();
}

include "conf.php";

// Retrieve the logged-in supplier's details using their email from the session
$email = $_SESSION['email'];
$sql = "SELECT * FROM suppliers WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$supplier = $result->fetch_assoc();

// Close the statement and database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Profile</title>
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
        <h1>Supplier</h1>
        <nav>
            <ul>
                <li><a href="supplierdashboard.php">Dashboard</a></li>
                <li><a href="supprofile.php">My Profile</a></li>
                <li><a href="manageorder.php">New Orders</a></li>
                <li><a href="supplogin.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-dashboard">
        <h1>Supplier's Profile</h1>
        <div class="profile-widget">
            <h2>Personal Information</h2>
            <ul>
                <li><strong>Name:</strong> <?= htmlspecialchars($supplier['supplier_name']) ?></li>
                <li><strong>Company:</strong> <?= htmlspecialchars($supplier['company']) ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($supplier['email']) ?></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
