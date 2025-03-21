<?php
include "conf.php"; // Include database configuration

// Check if 'request_id' and 'status' are passed in the GET request
if (isset($_GET['request_id']) && isset($_GET['status'])) {
    $request_id = intval($_GET['request_id']);
    $status = $_GET['status'];

    // Validate the status value
    if (!in_array($status, ['Accepted', 'Rejected'])) {
        echo "Invalid status value.";
        exit();
    }

    // Prepare the SQL query to update the request status
    $sql = "UPDATE lab_requests SET status = ? WHERE request_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Failed to prepare the query.";
        exit();
    }

    $stmt->bind_param("si", $status, $request_id); // Bind the parameters
    if ($stmt->execute()) { // Execute the query
        echo "Request status updated successfully.";
    } else {
        echo "Failed to update the request status.";
    }

    $stmt->close();
} else {
    echo "Missing request_id or status parameter.";
}

$conn->close();
?>
