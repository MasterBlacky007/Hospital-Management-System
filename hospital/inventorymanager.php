<?php
// Start session
session_start();

// Include the database connection file
include 'conf.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Manager Dashboard</title>
    <link rel="stylesheet" href="maindashboard.css">
</head>
<body>
    <!-- Sidebar for navigation -->
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

    <!-- Main content -->
    <div class="content">
        <div class="header">
            <h1>Inventory Manager Dashboard</h1>
        </div>

        <div class="dashboard">
            <div class="card">
                <h3>Stock Details</h3>
                <p>Manage Stocks</p>
                <a href="stockdash.php">View Stock</a>
            </div>
            <div class="card">
                <h3>Orders</h3>
                <p>Manage Pharmacy & Lab Orders</p>
                <a href="orders.php">View Orders</a>
            </div>
            <div class="card">
                <h3>Supplier Profiles</h3>
                <p>View  & Add Supplier Information</p>
                <a href="isupplierdash.php">View Profile</a>
            </div>
            <div class="card">
                <h3>Supplier Orders</h3>
                <p>Add & View orders </p>
                <a href="suporder.php">View Orders</a>
            </div>
            
        </div>
    </div>
</body>
</html>
