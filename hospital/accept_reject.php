<?php
include "conf.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if action is set (Accept or Reject)
if (isset($_POST['action']) && isset($_POST['contact_no'])) {
    $contact_no = $_POST['contact_no'];
    $action = $_POST['action'];  // This will be either "accept" or "reject"

    // Prepare the status value based on the action
    $status = ($action === 'accept') ? 'accept' : 'reject';

    // Update the status in the prescription table
    $query = "UPDATE prescription SET status = ? WHERE contact_no = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ss", $status, $contact_no);  // Bind status and contact_no to the query
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Successful update
            echo "<script>alert('Prescription status updated to " . ucfirst($status) . ".'); window.location.href = 'load_pres.php';</script>";
        } else {
            // No change in status (maybe no matching record)
            echo "<script>alert('No record found for the given Contact No.'); window.location.href = 'load_pres.php';</script>";
        }
    } else {
        // SQL error
        echo "<script>alert('Error updating the status. Please try again.'); window.location.href = 'load_pres.php';</script>";
    }
} else {
    // Redirect if action or contact_no is not set
    echo "<script>alert('Invalid request.'); window.location.href = 'load_pres.php';</script>";
}
?>
