<?php
session_start();
echo '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Manager</title>
    <link rel="stylesheet" href="dashboard1.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            
            <a href="MFdash.php">Dashboard</a>
            <a href="profilefm.php">My Profile</a>
            <a href="bugetr.php">Budget Reports</a>
            <a href="salary.php">Salary</a>
            <a href="paymentview.php">Payments</a>
            <a href="stlogin.html">Log Out</a>
        </div>

        <main class="main-content">
            <header>
                <h1>Finance Manager Dashboard</h1>
            </header>
            <section>
                <h2>Operations</h2><br><br>
                <div class="operations">
                    <div class="operation-box">
                        <img src="images/profile.png" alt="Edit Icon">
                        <a href="profilefm.php">Profile</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/bugetr.jpg" alt="Budget Icon">
                        <a href="bugetr.php">Budget Reports</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/salary.jpg" alt="Salary Icon">
                        <a href="salary.php">Salary Details</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/payment.webp" alt="Payment Icon">
                        <a href="paymentview.php">Payments</a>
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
