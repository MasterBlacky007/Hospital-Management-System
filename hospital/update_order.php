<?php
session_start();
include('conf.php'); // Replace with your database connection file

// Check if supplier is logged in
if (!isset($_SESSION['supplier_id'])) {
    header('Location: suplogin.php'); // Redirect to login page
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get order ID and action (Accept or Reject) from the form submission
    $order_id = $_POST['order_id'];
    $action = $_POST['action'];

    // Prepare the SQL statement to update the order status
    if ($action == 'Accept') {
        $status = 'Accepted';
    } elseif ($action == 'Reject') {
        $status = 'Rejected';
    } else {
        $_SESSION['error_message'] = 'Invalid action.';
        header('Location: view_orders.php');
        exit();
    }

    // Update the order status in the database
    $sql = "UPDATE orders SET status = ? WHERE order_id = ? AND supplier_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $status, $order_id, $_SESSION['supplier_id']);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Order status updated successfully.';
    } else {
        $_SESSION['error_message'] = 'Error updating order status. Please try again.';
    }

    // Redirect back to the orders page after updating
    header('Location: view_orders.php');
    exit();
} else {
    // Redirect if the request method is not POST
    header('Location: view_orders.php');
    exit();
}
?>
