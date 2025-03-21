<?php
include "conf.php";

// Check if the admission ID is provided
if (isset($_GET['id'])) {
    $admission_id = $_GET['id'];

    // SQL query to delete the admission record
    $sql = "DELETE FROM admissions WHERE admission_id = ?";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admission_id);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('Admission record deleted successfully.');
            window.location.href = 'viewadmission.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Error: Could not delete the admission record. Please try again.');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "
    <script>
        alert('Invalid request. No admission ID provided.');
        window.history.back();
    </script>";
}
?>
