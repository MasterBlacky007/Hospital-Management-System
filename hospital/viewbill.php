<?php
// Assuming a database connection is established
include('conf.php');

// Check if the patientID is set in the URL
if (isset($_GET['patientID'])) {
    $patientID = $_GET['patientID'];

    // Query to fetch the patient details
    $query = "SELECT * FROM patient WHERE id = '$patientID'";
    $patientResult = mysqli_query($conn, $query);

    // Check for errors in fetching patient data
    if (!$patientResult) {
        die("Error fetching patient data: " . mysqli_error($conn));
    }

    $patientData = mysqli_fetch_assoc($patientResult);

    // Query to fetch the bill details for the patient for the current date
    $billQuery = "SELECT * FROM bills WHERE patientID = '$patientID' AND DATE(date) = CURDATE()";
    $billResult = mysqli_query($conn, $billQuery);

    // Check for errors in fetching bill data
    if (!$billResult) {
        die("Error fetching bill data: " . mysqli_error($conn));
    }

    $billData = mysqli_fetch_assoc($billResult);

    // Fetch bill items if a bill exists
    $billItems = [];
    if ($billData) {
        $billID = $billData['billID'];
        $itemsQuery = "SELECT * FROM bill_items WHERE billID = '$billID'";
        $itemsResult = mysqli_query($conn, $itemsQuery);

        if (!$itemsResult) {
            die("Error fetching bill items: " . mysqli_error($conn));
        }

        while ($item = mysqli_fetch_assoc($itemsResult)) {
            $billItems[] = $item;
        }
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
    <title>Patient Bill - Mount Apollo Hospital</title>
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
                <td><strong>Bill Date:</strong> <?php echo date("Y-m-d"); ?></td>
                <td><strong>Patient ID:</strong> <?php echo htmlspecialchars($patientID); ?></td>
            </tr>
            <tr>
                <td><strong>First Name:</strong> <?php echo htmlspecialchars($patientData['firstName']); ?></td>
                <td><strong>Last Name:</strong> <?php echo htmlspecialchars($patientData['lastName']); ?></td>
                <td><strong>Address:</strong> <?php echo htmlspecialchars($patientData['address']); ?></td>
            </tr>
        </table>
    </div>

    <!-- Itemized Bill Table -->
    <h3>Itemized Bill</h3>
    <table class="bill-table">
        <thead>
            <tr>
                <th>Services</th>
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
                echo "<tr><td colspan='4'>No bill items found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Total Summary -->
    <div class="total-summary">
        <table>
            <tr>
                <td><strong>Grand Total:</strong></td>
                <td><?php echo htmlspecialchars($billData['grandTotal'] ?? '0.00'); ?> LKR</td>
            </tr>
            <tr>
                <td><strong>Paid Amount:</strong></td>
                <td><?php echo htmlspecialchars($billData['paidAmount'] ?? '0.00'); ?> LKR</td>
            </tr>
            <tr>
                <td><strong>Due Amount:</strong></td>
                <td><?php echo htmlspecialchars($billData['dueAmount'] ?? '0.00'); ?> LKR</td>
            </tr>
            <tr>
                <td><strong>Balance:</strong></td>
                <td><?php echo htmlspecialchars($billData['balance'] ?? '0.00'); ?> LKR</td>
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
