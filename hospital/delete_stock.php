<?php
// Include database connection
include 'conf.php';

// Get the stock ID from the URL
if (isset($_GET['id'])) {
    $stockId = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM stock_details WHERE stock_id = $stockId";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Stock record deleted successfully!'); window.location.href = 'stocktable.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($conn) . "'); window.location.href = 'stocktable.php';</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
