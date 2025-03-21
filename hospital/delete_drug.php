<?php
// Include database configuration file
include "conf.php";

// Check if the drug ID is provided in the URL
if (isset($_GET['id'])) {
    $drug_id = $_GET['id'];

    // Prepare the SQL query to delete the drug
    $sql = "DELETE FROM drugs WHERE drug_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the drug ID to the prepared statement
        $stmt->bind_param("i", $drug_id);

        // Execute the query
        if ($stmt->execute()) {
            // If the deletion is successful, redirect to the drug list page
            header("Location: druglist.php?success=1");
        } else {
            // If the query fails, display an error message
            echo "Error: " . $conn->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error preparing the query.";
    }
} else {
    echo "No drug ID provided!";
}

// Close the database connection
$conn->close();
?>
