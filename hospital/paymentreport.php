<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Reports</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="report.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Payment Reports</h2>
        </header>

        <!-- Dropdown Form -->
        <form method="GET" action="">
            <label for="reportType">Select Report Type:</label>
            <select id="reportType" name="reportType">
                <option value="weekly" <?php echo (isset($_GET['reportType']) && $_GET['reportType'] === 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                <option value="monthly" <?php echo (isset($_GET['reportType']) && $_GET['reportType'] === 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                <option value="yearly" <?php echo (isset($_GET['reportType']) && $_GET['reportType'] === 'yearly') ? 'selected' : ''; ?>>Yearly</option>
            </select>
            <button type="submit">View Report</button>
        </form>

        <!-- Action Buttons -->
        <div class="action-buttons">
        <button class="back-button" onclick="window.history.back()">Back to Results</button>

            <?php 
            // Ensure that $reportType is defined before using it
            $reportType = isset($_GET['reportType']) ? $_GET['reportType'] : 'weekly';
            ?>
            <a href="view_table.php?reportType=<?php echo $reportType; ?>" target="_blank">View Table & Print</a>
        </div>

        <?php
        // Include database connection
        include('conf.php');

        // Determine report type
        $reportType = isset($_GET['reportType']) ? $_GET['reportType'] : 'weekly';

        // Query based on selected report type
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

        <!-- Display the Report -->
        <h2><?php echo ucfirst($reportType); ?> Payment Report</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="transactions">
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
                            <td><?php echo $row['TotalRevenue']; ?></td>
                            <td><?php echo $row['TotalPaid']; ?></td>
                            <td><?php echo $row['TotalDue']; ?></td>
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

                    // Display analysis
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
