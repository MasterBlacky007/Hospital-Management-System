<?php
session_start();
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MLT Dashboard</title>
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
            <h1>MLT</h1>
            <nav>
                <a href="mltdashboard.php">Dashboard</a>
                <a href="profilemlt.php">My Profile</a>
                <a href="lreq.html">Test Requests</a>
                <a href="search.php">View Patient Details</a>
                <a href="labtestdash.php">Lab Test Result</a>
                <a href="labsuprdash.php">Lab Supply Request</a>
                <a href="stlogin.html">Log Out</a>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="content">
            <section class="dashboard">
                <div class="card">
                    <h3>My Profile</h3>
                    <p>View and update your profile.</p>
                    <a href="profilemlt.php">My Profile</a>
                </div>
                <div class="card">
                    <h3>Test Requests</h3>
                    <p>View and manage test requests.</p>
                    <a href="lab_req.html">Test Requests</a>
                </div>
                <div class="card">
                    <h3>Patient Details</h3>
                    <p>Search and view patient details.</p>
                    <a href="search.php">View Patient Details</a>
                </div>
                <div class="card">
                    <h3>Lab Test Results</h3>
                    <p>View and manage lab test results.</p>
                    <a href="labtestl.html">Lab Test Results</a>
                </div>
                <div class="card">
                    <h3>Lab Supply Request</h3>
                    <p>Request lab supplies.</p>
                    <a href="labsuprdash.php">Lab Supply Request</a>
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
';
?>
