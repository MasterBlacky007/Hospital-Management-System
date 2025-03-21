<?php 
// Include database connection
include('conf.php');

// Fetch all records from lab_supplies_request
$sql_supplies = "SELECT * FROM lab_supplies_request";
$result_supplies = mysqli_query($conn, $sql_supplies);

// Fetch all records from drug_orders
$sql_drugs = "SELECT * FROM drug_orders";
$result_drugs = mysqli_query($conn, $sql_drugs);

// Fetch all records from orders
$sql_orders = "SELECT * FROM orders";
$result_orders = mysqli_query($conn, $sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Orders</title>
    <link rel="stylesheet" href="report.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>View All Orders</h2>
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
            <?php $reportType = isset($_GET['reportType']) ? $_GET['reportType'] : 'weekly'; ?>
            <a href="ordersnew.php?reportType=<?php echo $reportType; ?>" target="_blank">View Table & Print</a>
        </div>

        <!-- Lab Supplies Requests Table -->
        <h2>Lab Supply Requests</h2>
        <table class="transactions">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Urgency</th>
                    <th>Request Date</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Decline Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_supplies)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['urgency']); ?></td>
                        <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['notes']); ?></td>
                        <td><?php echo htmlspecialchars($row['decline_reason']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Drug Orders Table -->
        <h2>Drug Orders</h2>
        <table class="transactions">
            <thead>
                <tr>
                    <th>Drug Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Dosage Form</th>
                    <th>Urgency</th>
                    <th>Request Date</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Decline Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_drugs)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['drug_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['dosage_form']); ?></td>
                        <td><?php echo htmlspecialchars($row['urgency']); ?></td>
                        <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['notes']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['decline_reason']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Supplier Orders Table -->
        <h2>Supplier Orders</h2>
        <table class="transactions">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Supplier ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_orders)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['supplier_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>

