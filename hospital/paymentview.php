<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Payments</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Finance Manager</h1>
        
            <a href="MFdash.php">Dashboard</a>
            <a href="profilefm.php">My Profile</a>
            <a href="bugetr.php">Budget Reports</a>
            <a href="salary.php">Salary</a>
            <a href="paymentview.php">Payments</a>
            <a href="stlogin.html">Log Out</a>

        </div>

        <main class="main-content">
            <header>
               
            </header>
            <section>
            <br><br>
                <div class="operations">
                    <div class="operation-box">
                        <img src="images/table.jpg" alt="Add Icon">
                        <a href="paymentbill.php">Cashier Payments</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/table.jpg" alt="View Icon">
                        <a href="paymentonline.php">Online Payments</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/report.jpg" alt="View Icon">
                        <a href="paymentreport.php">Cashier Payments Reports</a>
                    </div>
                </div>
            </section>
        </main>
    </div>

</body>
</html>
