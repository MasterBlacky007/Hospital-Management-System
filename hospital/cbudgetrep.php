<?php
// Database Connection
include "conf.php";

// Fetch Data from Budget Table
$budgetQuery = "SELECT * FROM budget";
$budgetResult = $conn->query($budgetQuery);

// Fetch Budget Analysis
$budgetAnalysisQuery = "
    SELECT 
        SUM(amount) AS totalBudget, 
        SUM(allocated_expenses) AS totalExpenses, 
        (SUM(amount) - SUM(allocated_expenses)) AS remainingBudget
    FROM budget";
$budgetAnalysisResult = $conn->query($budgetAnalysisQuery);
$analysisRow = $budgetAnalysisResult->fetch_assoc();
$totalBudget = $analysisRow['totalBudget'];
$totalExpenses = $analysisRow['totalExpenses'];
$remainingBudget = $analysisRow['remainingBudget'];

$conn->close();
date_default_timezone_set('Asia/Colombo');

$createdBy = "Center Manager"; 
$createdTime = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Report</title>
    <link rel="stylesheet" href="report1.css">
</head>
<body>
    <div class="report">
        <!-- Letterhead Section -->
        <div class="letterhead">
            <img src="logo.jpeg" alt="Logo" class="logo">
            <div class="details">
                <h1>MOUNT APOLLO HOSPITALS(PVT) LTD</h1>
                <p>No.355,Maharagama Road,Boralesgamuwa</p>
                <p>Tel:077 20 20 261,077 20 20 578,011 2 150 150
                <p>Email:info@mountapollohospitals.com | Web: www.mountapollohospitals.com</p>
            </div>
        </div>

        <!-- Created By and Date -->
        <div class="header-details">
            <div class="left">
                <p><strong>Created By:</strong> <?php echo $createdBy; ?></p>
            </div>
            <div class="right">
                <p><strong>Created Date & Time:</strong> <?php echo $createdTime; ?></p>
            </div>
        </div>

        <h2>Budget Report</h2>

        <!-- Print Button -->
        <button class="print-btn" onclick="window.print()">Print Report</button>

        <!-- Budget Overview Table -->
        <h2>Budget Overview</h2>
        <table>
            <thead>
                <tr>
                    <th>Total Budget</th>
                    <th>Total Expenses</th>
                    <th>Remaining Budget</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rs<?php echo number_format($totalBudget, 2); ?></td>
                    <td>Rs<?php echo number_format($totalExpenses, 2); ?></td>
                    <td>Rs<?php echo number_format($remainingBudget, 2); ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Detailed Budget Breakdown Table -->
        <h2>Detailed Budget Breakdown</h2>
        <table>
            <thead>
                <tr>
                    <th>Budget ID</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Allocated Expenses</th>
                    <th>Starting Date</th>
                    <th>Ending Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $budgetResult->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['budget_id']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>Rs<?php echo number_format($row['amount'], 2); ?></td>
                        <td>Rs<?php echo number_format($row['allocated_expenses'], 2); ?></td>
                        <td><?php echo $row['starting_date']; ?></td>
                        <td><?php echo $row['ending_date']; ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Budget Analysis Summary -->
        <div class="analysis">
            <h3>Analysis</h3>
            <ul>
                <li><strong>Total Budget:</strong> Rs<?php echo number_format($totalBudget, 2); ?></li>
                <li><strong>Total Allocated Expenses:</strong> Rs<?php echo number_format($totalExpenses, 2); ?></li>
                <li><strong>Remaining Budget:</strong> Rs<?php echo number_format($remainingBudget, 2); ?></li>
                <li><strong>Budget Utilization:</strong> <?php echo number_format(($totalExpenses / $totalBudget) * 100, 2); ?>%</li>
            </ul>
        </div>
    </div>
</body>
</html>
