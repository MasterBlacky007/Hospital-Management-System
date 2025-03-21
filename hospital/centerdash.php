<?php
// Include the database connection file
session_start();
include "conf.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mount Apollo Hospital</title>
    <link rel="stylesheet" href="maindashboard.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Center Manager</h1>
            <nav>
                <a href="centerdash.php">Dashboard</a>
                <a href="profilecenter.php">My Profile</a>
                <a href="centerstaffdash.php">Staff Profile</a>
                <a href="frecord.php">Financial Records</a>
                <a href="cinvendash.php">inventory Records</a>
                <a href="departrep.php">Department Reports</a>
                <a href="stlogin.html">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="content">
            <section class="dashboard">
                <div class="card">
                    <h3>View Profile</h3>
                    <p>View my Information</p>
                    <a href="view_staff_profile.php">View My Profile</a>
                </div>
                <div class="card">
                    <h3>Staff Profile</h3>
                    <p>Add, update, delete, view staff profiles</p>
                    <a href="centerstaffdash.php">Staff Profile</a>
                </div>
                <div class="card">
                    <h3>Financial Records</h3>
                    <p>Payment & Budget Analysis</p>
                    <a href="frecord.php">View Financial Records</a>
                </div>
                <div class="card">
                    <h3>Inventory Records</h3>
                    <p>Stock & Order Details</p>
                    <a href="cinvendash.php">View Inventory Records</a>
                </div>
                <div class="card">
                    <h3>Department Reports</h3>
                    <p>patient & Lab Analytics Reports</p>
                    <a href="cinvendash.php">View Department Reports</a>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Hospital Management System</p>
    </footer>
</body>
</html>
