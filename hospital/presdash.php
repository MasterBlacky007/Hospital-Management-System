<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Doctor</h1>
        
            <a href="doctordash.html">Dashboard</a>
                    <a href="docprofile.php">My Profile</a>
                    <a href="docviewptprofile.php">Patient Profile</a>
                    <a href="presdash.php">Prescription</a>
                    <a href="labdash.php">Lab Test</a>
                    <a href="docappointment.php">Appointment</a>
                    <a href="taskdash.php">Task</a>
                    <a href="viewdprogress.php">View Progress Notes</a>
                    <a href="stlogin.html">Log Out</a>

        
        </div>

        <main class="main-content">
            <header>
               
            </header>
            <section>
            <br><br>
                <div class="operations">
                    <div class="operation-box">
                        <img src="images/10.webp" alt="Add Icon">
                        <a href="prescriptions.php">Add Prescription</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/edit.png" alt="Edit Icon">
                        <a href="updatePrescriptions.php">Edit Prescription</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/delete.png" alt="Delete Icon">
                        <a href="deleteprescriptions.php">Delete Prescription</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/view.webp" alt="View Icon">
                        <a href="viewprescriptions.php">View Prescription</a>
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
