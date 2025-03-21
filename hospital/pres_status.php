<?php
// Database connection
include "conf.php";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the prescription ID and action
    $prescription_id = $_POST['prescription_id'];
    $action = $_POST['action'];

    // Validate inputs
    if (!empty($prescription_id) && in_array($action, ['accept', 'reject'])) {
        // Determine the status to update based on the action
        $status = ($action === 'accept') ? 'Accepted' : 'Rejected';

        // Update the prescription status in the database
        $sql = "UPDATE prescriptions SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $prescription_id);

        if ($stmt->execute()) {
            $message = "Prescription ID $prescription_id has been successfully $status.";
        } else {
            $message = "Error: Unable to update prescription status.";
        }
    } else {
        $message = "Invalid input. Please try again.";
    }
} else {
    $message = "Invalid request method.";
}

// Close the database connection
$conn->close();

// Redirect back to the previous page with a success or error message
header("Location: load_pres.php?message=" . urlencode($message));
exit;
?>
