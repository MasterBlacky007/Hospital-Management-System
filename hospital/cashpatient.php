<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard - Mount Apollo Hospital</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Cashier</h1>
        
            <a href="cashierdash.php">Dashboard</a>
            <a href="profilecashier.php">My Profile</a>
            <a href="cashpatient.php">Patient Details</a>
            <a href="billing.php">Generate Bill</a>
            <a href="invoice.php">View Bills</a>
            <a href="paymentonline.php">Transactions</a>
            <a href="stlogin.html">Log Out</a>
        </div>

        <main class="main-content">
            <header>
               
            </header>
            <section>
            <br><br>
                <div class="operations">
                    <div class="operation-box">
                        <img src="images/view.webp" alt="View Icon">
                        <a href="caspatients.php">View Patient Profiles</a>
                    </div>
                    <div class="operation-box">
                        <img src="images/view.webp" alt="View Icon">
                        <a href="cashregpat.php">View Registered patients</a>
                    </div>
                    
                </div>
            </section>
        </main>
    </div>

</body>
</html>
