<?php

include 'conf.php'; 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $item_number = mysqli_real_escape_string($conn, $_POST['item_number']);
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $ex_date = mysqli_real_escape_string($conn, $_POST['ex_date']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);

    // Validate that none of the fields are empty
    if (empty($item_name) || empty($quantity) || empty($ex_date) || empty($department)) {
        die("All fields are required.");
    }

    // Insert data into the database
    $sql = "INSERT INTO stock_details (item_name, quantity, ex_date, department)
            VALUES ('$item_name', '$quantity', '$ex_date', '$department')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Stock added successfully!'); window.location.href = 'addstock.html';</script>";
        
    } else {
        echo "<script>alert('Error adding stock: " . mysqli_error($conn) . "'); window.location.href = 'addstock.html';</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
