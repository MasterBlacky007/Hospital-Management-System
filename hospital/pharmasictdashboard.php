<?php
session_start();
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmasict Dashboard</title>
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
            <h1>Pharmacist</h1>
            <nav>
                <a href="pharmasictdashboard.php">Dashboard</a>
                <a href="profileph.php">My Profile</a>
                <a href="load_pres.php">Prescription</a>
                <a href="phdrugorderdash.php">Drug Order</a>
                <a href="drugstock.php">Drug Stock</a>
                <a href="mdhistory.php">MD History</a>
                <a href="drugdash.php">Drugs List</a>
                <a href="stlogin.html">Log Out</a>
            </nav>
        </div>

        <!-- Main Content Section -->
        <main class="content">
            <section class="dashboard">

                <div class="card">
                    <h3>Prescriptions</h3>
                    <p>Prescription for Drug relesing.</p>
                    <a href="phdrugorderdash.php">View Prescriptions</a>
                </div>
                <div class="card">
                    <h3>Drug Order</h3>
                    <p>Order drugs for the hospital.</p>
                    <a href="phdrugorderdash.php">View Orders</a>
                </div>
                <div class="card">
                    <h3>Drug Stock</h3>
                    <p>Manage the drug stock Pharmacy.</p>
                    <a href="drugstock.php">View Stock</a>
                </div>
                <div class="card">
                    <h3>Drugs List</h3>
                    <p>List of available drugs.</p>
                    <a href="drugdash.php">View Drugs</a>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Hospital Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
';
?>
