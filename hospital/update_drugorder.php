<?php
// Include database connection
include('conf.php');

// Check if form is submitted
if (isset($_POST['id']) && isset($_POST['action'])) {
    $order_id = $_POST['id'];
    $action = $_POST['action'];

    // Update query based on action
    if ($action == 'approve') {
        $sql = "UPDATE drug_orders SET status = 'Approved' WHERE id = $order_id";
    } elseif ($action == 'decline') {
        // Sanitize and update with decline reason
        $decline_reason = mysqli_real_escape_string($conn, $_POST['decline_reason']);
        $sql = "UPDATE drug_orders SET status = 'Declined', decline_reason = '$decline_reason' WHERE id = $order_id";
    }

    if (mysqli_query($conn, $sql)) {
        // Redirect to the orders page after the update
        header("Location: viewdrugorder.php");
        exit();
    } else {
        // Handle the error
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
