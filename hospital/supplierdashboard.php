<?php
session_start();
include "conf.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard</title>
    <link rel="stylesheet" href="maindashboard.css"> <!-- Use the same CSS -->
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Apollo Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Supplier</h1>
            <nav>
                <a href="supplierdashboard.php">Dashboard</a>
                <a href="supprofile.php">View Profile</a>
                <a href="manageorder.php">Orders</a>
                <a href="supplogin.php">Logout</a>
            </nav>
        </div>

        <!-- Main Content Section -->
        <main class="content">
            <section class="dashboard">
                <div class="card">
                    <h3>View Profile</h3>
                    <p>View my Information</p>
                    <a href="supprofile.php">View Profile</a>
                </div>
                <div class="card">
                    <h3>Manage Orders</h3>
                    <p>View & accept/reject Orders</p>
                    <a href="manageorder.php">View New Orders</a>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Apollo Hospital. All Rights Reserved.</p>
    </footer>
</body>
</html>
