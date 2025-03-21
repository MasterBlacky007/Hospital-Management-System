<?php

include 'conf.php';

// Check if the 'id' is set in the URL
if (isset($_GET['id'])) {
    $supplier_id = $_GET['id'];

    // Query to fetch the supplier data 
    $sql_check = "SELECT * FROM suppliers WHERE supplier_id = $supplier_id";
    $result_check = mysqli_query($conn, $sql_check);

    
    if (mysqli_num_rows($result_check) > 0) {

        // Query to delete the supplier 
        $sql_delete = "DELETE FROM suppliers WHERE supplier_id = $supplier_id";

        if (mysqli_query($conn, $sql_delete)) {
            echo "<script>alert('Supplier deleted successfully!'); window.location.href = 'viewsuppliers.php';</script>";
        } else {
            echo "<script>alert('Error deleting supplier: " . mysqli_error($conn) . "'); window.location.href = 'viewsuppliers.php';</script>";
        }
    } else {
        echo "<script>alert('Supplier not found!'); window.location.href = 'viewsuppliers.php';</script>";
    }
} else {
    echo "<script>alert('No supplier ID provided!'); window.location.href = 'viewsuppliers.php';</script>";
}


mysqli_close($conn);
?>
