<?php
// Include the database connection
include 'conf.php';

// Check if the ID is set and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $progressNId = $_GET['id'];

    // Prepare the delete statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM progressnotes WHERE progressNId = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $progressNId); // Bind the progressNId as an integer
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Progress note deleted successfully.');</script>";
        } else {
            echo "<script>alert('No record found with the provided ID.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing the delete query.');</script>";
    }
} else {
    echo "<script>alert('Invalid or missing ID.');</script>";
}

// Close the database connection
$conn->close();

// Redirect back to the progress notes list
echo "<script>window.location.href = 'viewprogresstable.php';</script>";
?>
