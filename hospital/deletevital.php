<?php
// Include the database connection
include 'conf.php';

// Check if the ID is set in the query string
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $vitalId = $_GET['id'];

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM vital_signs WHERE vitalId = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $vitalId);  // Bind the vitalId as an integer
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Record deleted successfully.');</script>";
        } else {
            echo "<script>alert('No record found with the provided ID.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing the query.');</script>";
    }
} else {
    echo "<script>alert('Invalid or missing ID.');</script>";
}

// Close the database connection
$conn->close();

// Redirect back to the vital signs list
echo "<script>window.location.href = 'vitaltable.php';</script>";
?>
