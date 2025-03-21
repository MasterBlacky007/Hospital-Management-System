<?php
// Include database connection
include('conf.php');

// Set the time zone to Sri Lanka Time (adjust if needed)
date_default_timezone_set('Asia/Colombo');

// Get the current date and time for "Created By" and "Created Date & Time"
$createdBy = "Finance Manager"; // Replace with actual user data
$createdTime = date("Y-m-d H:i:s"); // Current report generation time

// Query based on report type passed in the URL
$reportType = isset($_GET['reportType']) ? $_GET['reportType'] : 'weekly';

if ($reportType === 'weekly') {
    $query = "
        SELECT 
            YEAR(date) AS Year,
            WEEK(date) AS Week,
            SUM(grandTotal) AS TotalRevenue,
            SUM(paidAmount) AS TotalPaid,
            SUM(dueAmount) AS TotalDue
        FROM bills
        GROUP BY YEAR(date), WEEK(date)
        ORDER BY Year DESC, Week DESC;
    ";
} elseif ($reportType === 'monthly') {
    $query = "
        SELECT 
            YEAR(date) AS Year,
            MONTH(date) AS Month,
            SUM(grandTotal) AS TotalRevenue,
            SUM(paidAmount) AS TotalPaid,
            SUM(dueAmount) AS TotalDue
        FROM bills
        GROUP BY YEAR(date), MONTH(date)
        ORDER BY Year DESC, Month DESC;
    ";
} else { // Yearly
    $query = "
        SELECT 
            YEAR(date) AS Year,
            SUM(grandTotal) AS TotalRevenue,
            SUM(paidAmount) AS TotalPaid,
            SUM(dueAmount) AS TotalDue
        FROM bills
        GROUP BY YEAR(date)
        ORDER BY Year DESC;
    ";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payment Report</title>
    <link rel="stylesheet" href="report1.css">
</head>
<body>
    <div class="report">
        <!-- Letterhead Section -->
        <div class="letterhead">
            <img src="logo.jpeg" alt="Logo" class="logo">
            <div class="details">
                <h1>MOUNT APOLLO HOSPITALS (PVT) LTD</h1>
                <p>No. 355, Maharagama Road, Boralesgamuwa</p>
                <p>Tel: 077 20 20 261, 077 20 20 578, 011 2 150 150</p>
                <p>Email: info@mountapollohospitals.com | Web: www.mountapollohospitals.com</p>
            </div>
        </div>

        <!-- Header Details -->
        <div class="header-details">
            <div class="left">
                <p><strong>Created By:</strong> <?php echo $createdBy; ?></p>
            </div>
            <div class="right">
                <p><strong>Created Date & Time:</strong> <?php echo $createdTime; ?></p>
            </div>
        </div>

        <!-- Table Section for the Report -->
        <h2><?php echo ucfirst($reportType); ?> Payment Report</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <?php if ($reportType === 'weekly'): ?>
                            <th>Year</th>
                            <th>Week</th>
                        <?php elseif ($reportType === 'monthly'): ?>
                            <th>Year</th>
                            <th>Month</th>
                        <?php else: ?>
                            <th>Year</th>
                        <?php endif; ?>
                        <th>Total Revenue</th>
                        <th>Total Paid</th>
                        <th>Total Due</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <?php if ($reportType === 'weekly'): ?>
                                <td><?php echo $row['Year']; ?></td>
                                <td><?php echo $row['Week']; ?></td>
                            <?php elseif ($reportType === 'monthly'): ?>
                                <td><?php echo $row['Year']; ?></td>
                                <td><?php echo $row['Month']; ?></td>
                            <?php else: ?>
                                <td><?php echo $row['Year']; ?></td>
                            <?php endif; ?>
                            <td><?php echo number_format($row['TotalRevenue'], 2); ?></td>
                            <td><?php echo number_format($row['TotalPaid'], 2); ?></td>
                            <td><?php echo number_format($row['TotalDue'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Financial Analysis -->
            <div class="analysis">
                <h3>Financial Analysis</h3>
                <ul>
                    <?php
                    // Reset the pointer for analysis calculation
                    mysqli_data_seek($result, 0);

                    $totalRevenue = $totalPaid = $totalDue = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $totalRevenue += $row['TotalRevenue'];
                        $totalPaid += $row['TotalPaid'];
                        $totalDue += $row['TotalDue'];
                    }

                    // Calculate percentages
                    $paidPercentage = $totalRevenue ? ($totalPaid / $totalRevenue) * 100 : 0;
                    $duePercentage = $totalRevenue ? ($totalDue / $totalRevenue) * 100 : 0;
                    ?>
                    <li><strong>Total Revenue:</strong> <?php echo number_format($totalRevenue, 2); ?></li>
                    <li><strong>Total Paid:</strong> <?php echo number_format($totalPaid, 2); ?> (<?php echo number_format($paidPercentage, 2); ?>%)</li>
                    <li><strong>Total Due:</strong> <?php echo number_format($totalDue, 2); ?> (<?php echo number_format($duePercentage, 2); ?>%)</li>
                    <li><strong>Paid to Revenue Ratio:</strong> <?php echo number_format($paidPercentage, 2); ?>%</li>
                    <li><strong>Due to Revenue Ratio:</strong> <?php echo number_format($duePercentage, 2); ?>%</li>
                </ul>
            </div>
        <?php else: ?>
            <p>No data available for the selected report type.</p>
        <?php endif; ?>

        <!-- Close the database connection -->
        <?php mysqli_close($conn); ?>
    </div>
</body>
</html>
