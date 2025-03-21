<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard - Mount Apollo Hospital</title>
    <link rel="stylesheet" href="cashierdashboard.css">
</head>
<body>
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h2>Cashier Dashboard</h2>
        </header>

        <!-- Stats Section -->
        <section class="dashboard-stats">
            <div class="stat-box">
                <h3>Total Bills</h3>
                <p>
                    <?php

                    include "conf.php";
                    // Query to calculate the total bills amount
                    $sql = "SELECT SUM(grandTotal) AS total_bills FROM bills";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo "Rs." . number_format($row['total_bills'], 2);
                    ?>
                </p>
            </div>
            <div class="stat-box">
                <h3>Total Patients</h3>
                <p>
                    <?php
                    // Query to count total number of patients
                    $sql = "SELECT COUNT(*) AS total_patients FROM patient";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['total_patients'];
                    ?>
                </p>
            </div>
            <div class="stat-box">
                <h3>Total Transactions</h3>
                <p>
                    <?php
                    // Query to count total transactions
                    $sql = "SELECT COUNT(*) AS total_transactions FROM payments";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['total_transactions'];
                    ?>
                </p>
            </div>
            <div class="stat-box">
                <h3>Recent Transaction Count</h3>
                <p>
                    <?php
                    // Query to get the number of recent transactions
                    $sql = "SELECT COUNT(*) AS recent_transactions FROM payments WHERE paymentDate >= CURDATE()";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['recent_transactions'];
                    ?>
                </p>
            </div>
        </section>

        <!-- Noticeboard Section -->
       
                    
                </tbody>
            </table>
        </section>

                </tbody>
            </table>
        </section>
    </div>

</body>
</html>
