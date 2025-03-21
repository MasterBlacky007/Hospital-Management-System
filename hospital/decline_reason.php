<?php
// Include database connection
include('conf.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $reason = $_POST['reason'];

    // Update the status and add the decline reason
    $sql = "UPDATE lab_supplies_request 
            SET status = 'Declined', decline_reason = '$reason' 
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Request Declined!'); window.location.href = 'viewlaborders.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
