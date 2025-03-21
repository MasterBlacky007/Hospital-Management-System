<?php
// Database connection
include "conf.php";

// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
    // Get the patient ID from the URL
    $id = $_GET['id'];

    // SQL query to delete the patient record
    $sql = "DELETE FROM patient WHERE id = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the ID parameter
        $stmt->bind_param("i", $id);

        // Execute the statement
        if ($stmt->execute()) {
            // Success: Redirect with a success message
            echo "<script>
                    alert('Patient record deleted successfully.');
                    window.location.href = 'recptreg.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Error: Could not delete the patient record.');
                  </script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<script>
                alert('Error: Could not prepare the SQL statement.');
              </script>";
    }
} else {
    echo "<script>
            alert('Error: No patient ID provided.');
          </script>";
}

// Close the database connection
$conn->close();
?>
