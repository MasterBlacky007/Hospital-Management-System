<?php
// Include database connection
include('conf.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve patient details
    $patientID = mysqli_real_escape_string($conn, $_POST['patientID']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Retrieve billing details
    $accountNames = $_POST['accountName'];
    $descriptions = $_POST['description'];
    $quantities = $_POST['quantity'];
    $prices = $_POST['price'];
    $subtotals = $_POST['subtotal'];
    $grandTotal = mysqli_real_escape_string($conn, $_POST['grandTotal']);
    $paidAmount = mysqli_real_escape_string($conn, $_POST['paidAmount']);
    $dueAmount = mysqli_real_escape_string($conn, $_POST['dueAmount']);
    $balance = mysqli_real_escape_string($conn, $_POST['balance']);

    // Insert the bill into the `bills` table
    $billQuery = "INSERT INTO bills (patientid, firstName,lastName, address, date,contact, grandTotal, paidAmount, dueAmount, balance) 
                  VALUES ('$patientID', '$firstName', '$lastName','$address', '$date','$contact', '$grandTotal', '$paidAmount', '$dueAmount', '$balance')";

    if (mysqli_query($conn, $billQuery)) {
        // Get the last inserted bill ID
        $billID = mysqli_insert_id($conn);

        // Insert each billing item into the `bill_items` table
        foreach ($accountNames as $index => $accountName) {
            $description = mysqli_real_escape_string($conn, $descriptions[$index]);
            $quantity = mysqli_real_escape_string($conn, $quantities[$index]);
            $price = mysqli_real_escape_string($conn, $prices[$index]);
            $subtotal = mysqli_real_escape_string($conn, $subtotals[$index]);

            $itemQuery = "INSERT INTO bill_items (billID,patientid, accountName, description, quantity, price, subtotal) 
                          VALUES ('$billID','$patientID', '$accountName', '$description', '$quantity', '$price', '$subtotal')";
            
            mysqli_query($conn, $itemQuery);
        }

        // Redirect or display a success message
        echo "<script>alert('Bill generated successfully!'); window.location.href = 'billing.php';</script>";
    } else {
        // Handle error
        echo "<script>alert('Error generating bill: " . mysqli_error($conn) . "'); window.location.href = 'billing.php';</script>";
    }
} else {
    // Redirect to the billing page if the form is not submitted
    header('Location: billing.php');
    exit;
}

// Close the database connection
mysqli_close($conn);
?>
