<?php
session_start();
echo '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Receptionist</h1>
                    <a href="receptionistdashboard.html">Dashboard</a>
                    <a href="profilerec.php">My Profile</a>
                    <a href="patientRegister.html">Patient Registration</a>
                    <a href="patientprofile.html">Patient Profile</a>
                    <a href="receppatdet.php">Patient Details</a>
                    <a href="appointmentdash.php">Appointment</a>
                    <a href="visitordash.php">Visitors</a></li>
                    <a href="stlogin.html">Logout</a>
        </div>

        <main class="main-content">
            <header>
                <h1>Visitor</h1>
            </header>
            <section>
                <h2>Operations</h2><br><br>
                <div class="operations">
                <div class="operation-box">
                    <img src="images/10.webp" alt="Add Icon">
                    <a href="addvisitor.php">Add Visitor</a>
                </div>
                <div class="operation-box">
                    <img src="images/edit.png" alt="Edit Icon">
                    <a href="updatevisitor.php">Edit Visitor</a>
                </div>
                <div class="operation-box">
                    <img src="images/delete.png" alt="Delete Icon">
                    <a href="deletevisitor.html">Delete Visitor</a>
                </div>
                <div class="operation-box">
                    <img src="images/view.webp" alt="View Icon">
                    <a href="viewvisitor.php">View Visitors</a>
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
