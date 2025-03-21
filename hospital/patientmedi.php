<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Patient</h1>
                <a href="patientdash.html">Dashboard</a></li>
                <a href="profilepatient.php">My Profile</a>
                <a href="patientapp.php">Book Appointment</a>
                <a href="pappointment.php">View Appointments</a>
                <a href="patientmedi.php">Medical Records</a>
                <a href="viewpbill.php">Payment</a>
                <a href="feedback.php">Feedback</a>
                <a href="plogin.html">Logout</a>
        </div>

        <main class="main-content">
            <header>
               
            </header>
            <section>
            <br><br>
                <div class="operations">
                    <div class="operation-box">
                        <img src="images/lab.webp" alt="Add Icon">
                        <a href="lab_results_view.php">View Lab Test Results</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/pres.png" alt="View Icon">
                        <a href="pres_view.php">View Prescription</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/vital.png" alt="View Icon">
                        <a href="vitalpview.php">View Vital Signs</a>
                    </div>
                </div>
            </section>
        </main>
    </div>

</body>
</html>
