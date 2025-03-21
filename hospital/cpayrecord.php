<?php
include "conf.php";

// Initialize variables

date_default_timezone_set('Asia/Colombo');
$paymentData = []; // Array to store payment data
$billItemData = []; // Array to store bill item data
$totalPayments = 0;
$totalAmountPaid = 0;
$totalDueAmount = 0;
$totalCreditAmount = 0;
$totalDebitAmount = 0;
$totalPaypalAmount = 0;
$totalRevenue = 0;
$createdBy = "Center Manager"; 
$createdTime = date("Y-m-d H:i:s");

// Fetch total payments
$totalPaymentsQuery = "SELECT COUNT(*) AS total FROM payments";
$totalPaymentsResult = $conn->query($totalPaymentsQuery);
if ($totalPaymentsResult->num_rows > 0) {
    $totalPayments = $totalPaymentsResult->fetch_assoc()['total'];
}

// Fetch total amount paid
$totalAmountPaidQuery = "SELECT SUM(amount) AS total_paid FROM payments";
$totalAmountPaidResult = $conn->query($totalAmountPaidQuery);
if ($totalAmountPaidResult->num_rows > 0) {
    $totalAmountPaid = $totalAmountPaidResult->fetch_assoc()['total_paid'];
}

// Fetch total due amount
$totalDueAmountQuery = "SELECT SUM(dueAmount) AS total_due FROM bills";
$totalDueAmountResult = $conn->query($totalDueAmountQuery);
if ($totalDueAmountResult->num_rows > 0) {
    $totalDueAmount = $totalDueAmountResult->fetch_assoc()['total_due'];
}

// Fetch total credit payments
$totalCreditAmountQuery = "SELECT SUM(amount) AS total_credit FROM credit_table";
$totalCreditAmountResult = $conn->query($totalCreditAmountQuery);
if ($totalCreditAmountResult->num_rows > 0) {
    $totalCreditAmount = $totalCreditAmountResult->fetch_assoc()['total_credit'];
}

// Fetch total debit payments
$totalDebitAmountQuery = "SELECT SUM(amount) AS total_debit FROM debit_table";
$totalDebitAmountResult = $conn->query($totalDebitAmountQuery);
if ($totalDebitAmountResult->num_rows > 0) {
    $totalDebitAmount = $totalDebitAmountResult->fetch_assoc()['total_debit'];
}

// Fetch total PayPal payments
$totalPaypalAmountQuery = "SELECT SUM(amount) AS total_paypal FROM paypal_table";
$totalPaypalAmountResult = $conn->query($totalPaypalAmountQuery);
if ($totalPaypalAmountResult->num_rows > 0) {
    $totalPaypalAmount = $totalPaypalAmountResult->fetch_assoc()['total_paypal'];
}

// Fetch total revenue from bill items (subtotal of all bill items)
$totalRevenueQuery = "SELECT SUM(subtotal) AS total_revenue FROM bill_items";
$totalRevenueResult = $conn->query($totalRevenueQuery);
if ($totalRevenueResult->num_rows > 0) {
    $totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'];
}

// Fetch payment breakdown
$paymentTypeQuery = "SELECT paymentType, SUM(amount) AS total_amount FROM payments GROUP BY paymentType";
$paymentTypeResult = $conn->query($paymentTypeQuery);
if ($paymentTypeResult->num_rows > 0) {
    while ($row = $paymentTypeResult->fetch_assoc()) {
        $paymentData[] = [
            'paymentType' => $row['paymentType'],
            'total_amount' => $row['total_amount']
        ];
    }
}

// Fetch revenue-wise analysis breakdown
$billItemQuery = "SELECT accountName, SUM(subtotal) AS total_revenue FROM bill_items GROUP BY accountName";
$billItemResult = $conn->query($billItemQuery);
if ($billItemResult->num_rows > 0) {
    while ($row = $billItemResult->fetch_assoc()) {
        $billItemData[] = [
            'accountName' => $row['accountName'],
            'total_revenue' => $row['total_revenue']
        ];
    }
}

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Report</title>
    <link rel="stylesheet" href="report1.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container report">
        <div class="letterhead">
            <img src="logo.jpeg" alt="Logo" class="logo"> <!-- Replace with your logo path -->
            <div class="details">
                <h1>MOUNT APOLLO HOSPITALS (PVT) LTD</h1>
                <p>No. 355, Maharagama Road, Boralesgamuwa</p>
                <p>Tel: 077 20 20 261, 077 20 20 578, 011 2 150 150</p>
                <p>Email: info@mountapollohospitals.com | Web: www.mountapollohospitals.com</p>
            </div>
        </div>
        <div class="header-details">
            <div class="left">
                <p><strong>Created By:</strong> <?php echo $createdBy; ?></p>
            </div>
            <div class="right">
                <p><strong>Created Date & Time:</strong> <?php echo $createdTime; ?></p>
            </div>
        </div>

        <h2>Financial Report</h2>

        <!-- Payment Breakdown Table -->
        <table>
            <thead>
                <tr>
                    <th>Payment Type</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($paymentData)) {
                    foreach ($paymentData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['paymentType']); ?></td>
                        <td><?php echo number_format($data['total_amount'], 2); ?></td>
                    </tr>
                    <?php endforeach; 
                } else {
                    echo "<tr><td colspan='2'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Revenue-wise Analysis Table -->
        <h3>Revenue Breakdown by Account</h3>
        <table>
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($billItemData)) {
                    foreach ($billItemData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['accountName']); ?></td>
                        <td><?php echo number_format($data['total_revenue'], 2); ?></td>
                    </tr>
                    <?php endforeach; 
                } else {
                    echo "<tr><td colspan='2'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="summary">
            <h2>Summary</h2>
            <p><strong>Total Payments:</strong> <?php echo $totalPayments; ?></p>
            <p><strong>Total Amount Paid:</strong> <?php echo number_format($totalAmountPaid, 2); ?></p>
            <p><strong>Total Due Amount:</strong> <?php echo number_format($totalDueAmount, 2); ?></p>
            <p><strong>Total Credit Payments:</strong> <?php echo number_format($totalCreditAmount, 2); ?></p>
            <p><strong>Total Debit Payments:</strong> <?php echo number_format($totalDebitAmount, 2); ?></p>
            <p><strong>Total PayPal Payments:</strong> <?php echo number_format($totalPaypalAmount, 2); ?></p>
            <p><strong>Total Revenue (from bill items):</strong> <?php echo number_format($totalRevenue, 2); ?></p>
        </div>

        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>
</body>
</html>
