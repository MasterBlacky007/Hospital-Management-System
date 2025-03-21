<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Center Manager Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <nav>
                <h1><center>Center Manager</center></h1>
                <ul>
                <a href="centerdash.php">Dashboard</a>
                <a href="profilecenter.php">My Profile</a>
                <a href="centerstaffdash.php">Staff Profile</a>
                <a href="frecord.php">Financial Records</a>
                <a href="cinvendash.php">inventory Records</a>
                <a href="departrep.php">Department Reports</a>
                <a href="stlogin.html">Logout</a>
                </ul>
            </nav>
        </div>

        <main class="main-content">
            <header>
               
            </header>
            <section>
            <br><br>
                <div class="operations">
                    <div class="operation-box">
                        <img src="images/payment.webp" alt="Add Icon">
                        <a href="cpayrecord.php">Payment Records</a>
                    </div>

                    <div class="operation-box">
                        <img src="images/payment.webp" alt="Add Icon">
                        <a href="paymentreport.php">Payment Records(W/M/Y)</a>
                    </div>
                    
                    <div class="operation-box">
                        <img src="images/budget.jpg" alt="View Icon">
                        <a href="cbudgetrep.php">View Budget</a>
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
