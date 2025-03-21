<?php
// Database connection
include "conf.php";

// Check if the test ID is provided
if (isset($_GET['id'])) {
    $testID = $_GET['id'];

    // Fetch the file path to delete the associated file
    $fetchSql = "SELECT filePath FROM lab_test_results WHERE id = ?";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bind_param("i", $testID);
    $fetchStmt->execute();
    $fetchResult = $fetchStmt->get_result();
    $filePath = null;

    if ($fetchResult->num_rows > 0) {
        $row = $fetchResult->fetch_assoc();
        $filePath = $row['filePath'];
    }

    // Delete the test result from the database
    $deleteSql = "DELETE FROM lab_test_results WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $testID);

    if ($deleteStmt->execute()) {
        // Delete the associated file from the server, if it exists
        if ($filePath && file_exists($filePath)) {
            unlink($filePath);
        }

        echo "<script>alert('Test result deleted successfully.');window.location.href = 'viewlabtest.php';</script>";
      
    } else {
        echo "Error deleting test result: " . $conn->error;
    }
} else {
    echo "Test ID not provided.";
}
?>
