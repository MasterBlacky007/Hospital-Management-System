<?php
// Include database connection
include "conf.php";

// Check if ID is set in URL
if (isset($_GET['id'])) {
    $patientId = intval($_GET['id']);

    // Prepare and bind statement to delete the patient record
    $stmt = $conn->prepare("DELETE FROM patientprofile WHERE id = ?");
    $stmt->bind_param("i", $patientId);

    if ($stmt->execute()) {
        echo "<script>alert('Patient record deleted successfully.'); window.location.href = 'recviewrpat.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $stmt->error . "'); window.location.href = 'recviewrpat.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No patient ID specified.'); window.location.href = 'recviewrpat.php';</script>";
}

$conn->close();
?>
