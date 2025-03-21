<?php
session_start();
echo '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vital Sign Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Nurse</h1>
            <nav>
                <a href="nursedashboard.html">Dashboard</a>
                <a href="nursepatient.php">Patient Profile</a>
                <a href="roomdash.php">Room</a>
                <a href="admissiondash.php">Admission</a>
                <a href="mytask.php">My Task</a>
                <a href="viewlabtest.php">View Lab Test Results</a>
                <a href="pres_view.php">View Prescription</a>
                <a href="vitalsigndash.php">Vital Sign</a>
                <a href="progressdash.php">Progress Notes</a>
                <a href="stlogin.html">Logout</a>
            </nav>
        </div>

        <main class="main-content">
            <header>
                <h1>Vital Sign</h1>
            </header>
            <section>
                <h2>Operations</h2><br><br>
                <div class="operations">
                <div class="operation-box">
                    <img src="images/10.webp" alt="Add Icon">
                    <a href="vitalsign.html">Add Vital Signs</a>
                </div>
                <div class="operation-box">
                    <img src="images/view.webp" alt="View Icon">
                    <a href="vitaltable.php">View Vitalsigns</a>
                </div>
            </div>

            </section>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Hospital Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
';
?>
