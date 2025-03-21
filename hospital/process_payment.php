<?php
// Include the database connection
include('conf.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch input data
    $billID = mysqli_real_escape_string($conn, $_POST['billID']);
    $paymentType = mysqli_real_escape_string($conn, $_POST['paymentType']);
    $paymentDate = mysqli_real_escape_string($conn, $_POST['paymentDate']);
    $dueAmount = (float)mysqli_real_escape_string($conn, $_POST['dueAmount']);

    // If no payment is required
    if ($dueAmount <= 0) {
        echo "<script>alert('No payment is required. You don\'t have an outstanding balance.'); window.location.href='pay.php';</script>";
        exit;
    }

    $amount = $dueAmount; // Assuming full payment
    $createdAt = date('Y-m-d H:i:s');
    $updatedAt = date('Y-m-d H:i:s');

    // Fetch patient ID and bill details
    $billQuery = "SELECT patientid, paidAmount, grandTotal FROM bills WHERE billID = '$billID'";
    $billResult = mysqli_query($conn, $billQuery);

    if (!$billResult || mysqli_num_rows($billResult) === 0) {
        die("Error fetching bill details: " . mysqli_error($conn));
    }

    $billData = mysqli_fetch_assoc($billResult);
    $patientID = $billData['patientid'];
    $paidAmount = $billData['paidAmount'];
    $grandTotal = $billData['grandTotal'];

    // Calculate the new paid amount and balance
    $newPaidAmount = $paidAmount + $amount;
    $newBalance = $grandTotal - $newPaidAmount;

    // Prevent overpayment
    if ($newBalance < 0) {
        echo "<script>alert('Overpayment is not allowed. Please check the due amount.'); window.location.href='pay.php';</script>";
        exit;
    }

    // Check if the expiry date is in the correct format
if ($paymentType === 'Credit') {
    $cardNumber = mysqli_real_escape_string($conn, $_POST['creditCardNumber']);
    $expiryDate = mysqli_real_escape_string($conn, $_POST['creditExpiryDate']);
    $cvv = mysqli_real_escape_string($conn, $_POST['creditCvv']);

    // Convert the expiry date to the correct format (YYYY-MM-01)
    $expiryDateFormatted = $expiryDate . '-01';  // Assuming you need the first day of the month

    $creditQuery = "INSERT INTO credit_table (billID, card_number, expiry_date, cvv, amount, payment_date) 
                    VALUES ('$billID', '$cardNumber', '$expiryDateFormatted', '$cvv', '$amount', '$paymentDate')";
    if (!mysqli_query($conn, $creditQuery)) {
        die("Error inserting into credit_table: " . mysqli_error($conn));
    }
} elseif ($paymentType === 'Debit') {
    $cardNumber = mysqli_real_escape_string($conn, $_POST['debitCardNumber']);
    $expiryDate = mysqli_real_escape_string($conn, $_POST['debitExpiryDate']);
    $cvv = mysqli_real_escape_string($conn, $_POST['debitCvv']);

    // Convert the expiry date to the correct format (YYYY-MM-01)
    $expiryDateFormatted = $expiryDate . '-01';  // Assuming you need the first day of the month

    $debitQuery = "INSERT INTO debit_table (billID, card_number, expiry_date, cvv, amount, payment_date) 
                   VALUES ('$billID', '$cardNumber', '$expiryDateFormatted', '$cvv', '$amount', '$paymentDate')";
    if (!mysqli_query($conn, $debitQuery)) {
        die("Error inserting into debit_table: " . mysqli_error($conn));
    }
} elseif ($paymentType === 'Paypal') {
    $email = mysqli_real_escape_string($conn, $_POST['paypalEmail']);
    $verificationCode = mysqli_real_escape_string($conn, $_POST['paypalVerificationCode']);

    $paypalQuery = "INSERT INTO paypal_table (billID, email, verification_code, amount, payment_date) 
                    VALUES ('$billID', '$email', '$verificationCode', '$amount', '$paymentDate')";
    if (!mysqli_query($conn, $paypalQuery)) {
        die("Error inserting into paypal_table: " . mysqli_error($conn));
    }
} else {
    die("Invalid payment type selected.");
}


    // Insert into payments table
    $paymentQuery = "INSERT INTO payments (billID, patientID, paymentType, amount, paymentDate, created_at, updated_at) 
                     VALUES ('$billID', '$patientID', '$paymentType', '$amount', '$paymentDate', '$createdAt', '$updatedAt')";
    if (!mysqli_query($conn, $paymentQuery)) {
        die("Error inserting into payments table: " . mysqli_error($conn));
    }

    // Update the bills table with the new paid amount and balance
    $updateBillQuery = "UPDATE bills 
                         SET paidAmount = '$newPaidAmount', 
                             dueAmount = '$newBalance', 
                             balance = '$newBalance' 
                         WHERE billID = '$billID'";
    if (!mysqli_query($conn, $updateBillQuery)) {
        die("Error updating bills table: " . mysqli_error($conn));
    }

    // Success response
    echo "<script>alert('Payment successfully processed.'); window.location.href='viewp.php';</script>";
} else {
    die("Invalid request method.");
}

// Close the database connection
mysqli_close($conn);
?>
