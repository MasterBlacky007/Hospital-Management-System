<?php

include "conf.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data
    $supplier_name = $_POST['supplier_name'];
    $company = $_POST['company'];
    $contact_no = $_POST['contact_no'];
    $user_email = $_POST['user_email'];
    $nic = $_POST['nic'];
    $company_address = $_POST['company_address'];
    $item_names = $_POST['item_names'];
    $password = $_POST['password'];

    // Check if the NIC already exists in the database
    $check_nic_query = "SELECT * FROM suppliers WHERE nic = '$nic'";
    $result = mysqli_query($conn, $check_nic_query);

    if (mysqli_num_rows($result) > 0) {
        // NIC already exists, show an error message
        echo "Error: A supplier with this NIC already exists. Please enter a different NIC.";
    } else {
        // Prepare the SQL query to insert data into the suppliers table
        $sql = "INSERT INTO suppliers (supplier_name, company, contact_no, email, nic, company_address, item_names, password) 
                VALUES ('$supplier_name', '$company', '$contact_no', '$user_email', '$nic', '$company_address', '$item_names', '$password')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Supplier profile added successfully!');window.location.href = 'addsupplier.html';</script>";

        } else {
            echo "<script>alert('Error adding Supplier: " . mysqli_error($conn) . "'); window.location.href = 'addsupplier.html';</script>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
