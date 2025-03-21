<?php
session_start();
echo '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
        <div class="logo">
            <img src="logo.jpeg" alt="Hospital Logo">
            <h2>Apollo Hospital</h2>
        </div>
        <h1>Inventory Manager</h1>
        <nav>
            <a href="inventorymanager.php">Dashboard</a>
                <a href="profileinventory.php">My Profile</a>
                <a href="stockdash.php">Stock</a>
                <a href="orders.php">Orders</a>
                <a href="isupplierdash.php">Suplier Profiles</a>
                <a href="suporder.php">Supplier Orders</a>
                <a href="stlogin.html">Logout</a>
        </nav>
    </div>

        <main class="main-content">
            <header>
                <h1>Add Stocks</h1>
            </header>
            <section>
                <h2>Operations</h2><br><br>
                <div class="operations">
                <div class="operation-box">
                    <img src="images/10.webp" alt="Add Icon">
                    <a href="addstock.html">Add Add Stocks</a>
                </div>
                <div class="operation-box">
                    <img src="images/view.webp" alt="View Icon">
                    <a href="stocktable.php">View Stocks</a>
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
