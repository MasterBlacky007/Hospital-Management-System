<?php
// Include the database connection
include('conf.php');

// Check if the billID is set in the URL
if (isset($_GET['billID'])) {
    $billID = $_GET['billID'];

    // Query to fetch bill details
    $billQuery = "SELECT * FROM bills WHERE billID = '$billID'";
    $billResult = mysqli_query($conn, $billQuery);

    // Check for errors in fetching bill data
    if (!$billResult) {
        die("Error fetching bill data: " . mysqli_error($conn));
    }

    $billData = mysqli_fetch_assoc($billResult);

    // Query to fetch patient details
    $patientID = $billData['patientid'];
    $patientQuery = "SELECT * FROM patient WHERE id = '$patientID'";
    $patientResult = mysqli_query($conn, $patientQuery);

    if (!$patientResult) {
        die("Error fetching patient data: " . mysqli_error($conn));
    }

    $patientData = mysqli_fetch_assoc($patientResult);

    // Query to fetch bill items
    $itemsQuery = "SELECT * FROM bill_items WHERE billID = '$billID'";
    $itemsResult = mysqli_query($conn, $itemsQuery);

    if (!$itemsResult) {
        die("Error fetching bill items: " . mysqli_error($conn));
    }

    $billItems = [];
    while ($item = mysqli_fetch_assoc($itemsResult)) {
        $billItems[] = $item;
    }

    // Close the connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bill</title>
    <link rel="stylesheet" href="printbill.css">
</head>
<body>

<div class="bill-container">
    <!-- Hospital Header -->
    <div class="bill-header">
        <img src="logo.jpeg" alt="Hospital Logo" class="logo">
        <div class="hospital-info">
            <h1>MOUNT APOLLO HOSPITALS (PVT) LTD</h1>
            <p>No. 355, Maharagama Road, Boralesgamuwa</p>
            <p>
                Tel: 077 20 20 261, 077 20 20 578, 011 2 150 150<br>
                Email: info@mountapollohospitals.com<br>
                Web: www.mountapollohospitals.com
            </p>
        </div>
    </div>
    <hr>

    <!-- Bill Information -->
    <div class="bill-info">
        <table>
            <tr>
                <td><strong>Bill Date:</strong> <?php echo htmlspecialchars($billData['date']); ?></td>
                <td><strong>Patient ID:</strong> <?php echo htmlspecialchars($patientID); ?></td>
            </tr>
            <tr>
                <td><strong>Patient Name:</strong> <?php echo htmlspecialchars($patientData['firstName'] . ' ' . $patientData['lastName']); ?></td>
                <td><strong>Address:</strong> <?php echo htmlspecialchars($patientData['address']); ?></td>
            </tr>
        </table>
    </div>

    <!-- Itemized Bill Table -->
    <h3>Itemized Bill</h3>
    <table class="bill-table">
        <thead>
            <tr>
                <th>Service</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price (LKR)</th>
                <th>Total (LKR)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($billItems)) {
                foreach ($billItems as $item) {
                    echo "<tr>
                            <td>" . htmlspecialchars($item['accountName']) . "</td>
                            <td>" . htmlspecialchars($item['description']) . "</td>
                            <td>" . htmlspecialchars($item['quantity']) . "</td>
                            <td>" . htmlspecialchars($item['price']) . "</td>
                            <td>" . htmlspecialchars($item['subtotal']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No items found for this bill.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Total Summary -->
    <div class="total-summary">
        <table>
            <tr>
                <td><strong>Grand Total:</strong></td>
                <td><?php echo htmlspecialchars($billData['grandTotal']); ?> LKR</td>
            </tr>
            <tr>
                <td><strong>Paid Amount:</strong></td>
                <td><?php echo htmlspecialchars($billData['paidAmount']); ?> LKR</td>
            </tr>
            <tr>
                <td><strong>Due Amount:</strong></td>
                <td><?php echo htmlspecialchars($billData['dueAmount']); ?> LKR</td>
            </tr>
            <tr>
                <td><strong>Balance:</strong></td>
                <td><?php echo htmlspecialchars($billData['balance']); ?> LKR</td>
            </tr>
        </table>
    </div>

    <hr>

    <!-- Footer Section -->
    <div class="bill-footer">
        <p>Thank you for choosing Mount Apollo Hospitals.</p>
        <p>This is a computer-generated invoice and does not require a signature.</p>
    </div>

    <!-- Print Button -->
    <button class="print-btn" onclick="window.print()">Print Bill</button>
</div>

</body>
</html>
