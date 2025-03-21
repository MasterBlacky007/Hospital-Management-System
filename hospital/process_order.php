<?php

include('conf.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $request_date = $_POST['request_date'];
    $drug_name = $_POST['drug_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $dosage_form = $_POST['dosage_form'];
    $urgency = $_POST['urgency'];
    $notes = $_POST['notes'];

    // Prepare and bind the SQL query to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO drug_orders (request_date,drug_name, category, quantity, dosage_form, urgency, notes) 
                            VALUES (?,?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisss",$request_date, $drug_name, $category, $quantity, $dosage_form, $urgency, $notes);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Drug stock order placed successfully!'); window.location.href = 'drug_order.html';</script>";
        exit;
    } else {
        echo "Error placing order: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
