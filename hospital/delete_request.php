<?php
include "conf.php"; // Include database configuration

// Check if 'request_id' is passed in the GET request
if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // Check if the 'request_id' is a valid integer
    if (filter_var($request_id, FILTER_VALIDATE_INT)) {
        $sql = "DELETE FROM lab_requests WHERE request_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing query: " . $conn->error;
            exit();
        }

        $stmt->bind_param("i", $request_id); // Bind the 'request_id' parameter

        if ($stmt->execute()) {
            echo "Request deleted successfully.";
        } else {
            echo "Error deleting request: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid request ID.";
    }
} else {
    echo "Request ID parameter is missing.";
}

$conn->close();
?>
