<?php
// Include database connection
include "conf.php";

// Check if request ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $request_id = $_GET['id'];

    // Prepare SQL DELETE query to remove the lab request
    $sql = "DELETE FROM lab_requests WHERE request_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the request_id parameter and execute the query
        $stmt->bind_param("i", $request_id);
        if ($stmt->execute()) {
            echo "<script>
                    alert('Lab request deleted successfully!');
                    window.location.href = 'viewlabreq.php'; // Redirect after successful deletion
                  </script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='viewlabreq.php';</script>";
}

// Close the connection
$conn->close();
?>
