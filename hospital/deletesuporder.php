<?php
// Include the database connection file
include "conf.php";

// Check if the order ID is provided
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']); // Get and sanitize the order ID

    // Prepare the SQL query to delete the order
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the order ID to the query
        mysqli_stmt_bind_param($stmt, "i", $order_id);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Redirect with a success message
            echo "<script>
                alert('Order deleted successfully!');
                window.location.href = 'viewsuporder.php';
            </script>";
        } else {
            // Redirect with an error message
            echo "<script>
                alert('Error deleting order: " . mysqli_error($conn) . "');
                window.location.href = 'viewsuporder.php';
            </script>";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Error preparing the statement
        echo "<script>
            alert('Error preparing the delete query: " . mysqli_error($conn) . "');
            window.location.href = 'viewsuporder.php';
        </script>";
    }
} else {
    // Redirect if no order ID is provided
    echo "<script>
        alert('Invalid order ID!');
        window.location.href = 'viewsuporder.php';
    </script>";
}

// Close the database connection
mysqli_close($conn);
?>
