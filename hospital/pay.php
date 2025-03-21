<?php
// Include the database connection
include('conf.php');

// Initialize variables
$billData = [];
$patientData = [];

if (isset($_GET['billID'])) {
    $billID = $_GET['billID'];

    // Query to fetch the bill details
    $billQuery = "SELECT * FROM bills WHERE billID = '$billID'";
    $billResult = mysqli_query($conn, $billQuery);

    if ($billResult && mysqli_num_rows($billResult) > 0) {
        $billData = mysqli_fetch_assoc($billResult);

        // Fetch the patient details
        $patientID = $billData['patientid'];
        $patientQuery = "SELECT * FROM patient WHERE id = '$patientID'";
        $patientResult = mysqli_query($conn, $patientQuery);

        if ($patientResult && mysqli_num_rows($patientResult) > 0) {
            $patientData = mysqli_fetch_assoc($patientResult);
        } else {
            $patientData = ['firstName' => 'Unknown', 'lastName' => 'Patient'];
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <link rel="stylesheet" href="pay.css">
    <script>
        function showPaymentDetails() {
            const paymentType = document.getElementById("paymentType").value;
            document.getElementById("debitFields").style.display = (paymentType === "Debit") ? "block" : "none";
            document.getElementById("creditFields").style.display = (paymentType === "Credit") ? "block" : "none";
            document.getElementById("paypalFields").style.display = (paymentType === "Paypal") ? "block" : "none";
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Make Payment</h2>
    <form action="process_payment.php" method="POST">
        <!-- Display Bill Details -->
        <label>Bill ID:</label>
        <input type="text" name="billID" value="<?php echo htmlspecialchars($billData['billID'] ?? 'N/A'); ?>" readonly>

        <label>Patient Name:</label>
        <input type="text" value="<?php echo htmlspecialchars(($patientData['firstName'] ?? '') . ' ' . ($patientData['lastName'] ?? '')); ?>" readonly>

        <label>Bill Date:</label>
        <input type="text" value="<?php echo htmlspecialchars($billData['date'] ?? 'N/A'); ?>" readonly>

        <label>Due Amount (LKR):</label>
        <input type="text" name="dueAmount" value="<?php echo htmlspecialchars($billData['dueAmount'] ?? 0); ?>" readonly>

        <!-- Payment Date -->
        <label for="paymentDate">Payment Date:</label>
        <input type="date" id="paymentDate" name="paymentDate" value="<?php echo date('Y-m-d'); ?>" required>

        <!-- Payment Type Selection -->
        <label for="paymentType">Select Payment Type:</label>
        <select name="paymentType" id="paymentType" onchange="showPaymentDetails()" required>
            <option value="">-- Select Payment Type --</option>
            <option value="Debit">Debit Card</option>
            <option value="Credit">Credit Card</option>
            <option value="Paypal">Paypal</option>
        </select>

        <!-- Debit Card Fields -->
        <div id="debitFields" style="display: none;">
            <label for="debitCardNumber">Card Number:</label>
            <input type="text" name="debitCardNumber" placeholder="Enter Debit Card Number">

            <label for="debitExpiryDate">Expiry Date:</label>
            <input type="month" name="debitExpiryDate">

            <label for="debitCvv">CVV:</label>
            <input type="password" name="debitCvv" placeholder="Enter CVV">
        </div>

        <!-- Credit Card Fields -->
        <div id="creditFields" style="display: none;">
            <label for="creditCardNumber">Card Number:</label>
            <input type="text" name="creditCardNumber" placeholder="Enter Credit Card Number">

            <label for="creditExpiryDate">Expiry Date:</label>
            <input type="month" name="creditExpiryDate">

            <label for="creditCvv">CVV:</label>
            <input type="password" name="creditCvv" placeholder="Enter CVV">
        </div>

        <!-- Paypal Fields -->
        <div id="paypalFields" style="display: none;">
            <label for="paypalEmail">Paypal Email:</label>
            <input type="email" name="paypalEmail" placeholder="Enter Paypal Email">

            <label for="paypalVerificationCode">Verification Code:</label>
            <input type="text" name="paypalVerificationCode" placeholder="Enter Verification Code">
        </div>

        <!-- Submit Button -->
        <button type="submit">Pay Now</button>

        <!-- Back Button -->
        <a href="viewpbill.php" class="back-button">Back</a>
    </form>
</div>
</body>
</html>
