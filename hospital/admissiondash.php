<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Addmission</title>
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
        
            <a href="nursedashboard.html">Dashboard</a>
                <a href="nursepatient.php">Patient Profile</a>
                <a href="roomdash.php">Room</a>
                <a href="admissiondash.php">Admission</a>
                <a href="my_task.php">My Task</a>
                <a href="nurse_lab.php">View Lab Test Results</a>
                <a href="nurse_pres.php">View Prescription</a>
                <a href="vitalsigndash.php">Vital Sign</a>
                <a href="progressdash.php">Progress Notes</a>
                <a href="stlogin.html">Logout</a>
        </div>

        <main class="main-content">
            <header>
               
            </header>
            <section>
            <br><br>
                <div class="operations">
                    <div class="operation-box">
                        <img src="images/10.webp" alt="Add Icon">
                        <a href="addmission.html">Add Admission</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/view.webp" alt="View Icon">
                        <a href="view_discharge.php">View Admission</a>
                    </div>
                </div>
            </section>
        </main>
    </div>

</body>
</html>
