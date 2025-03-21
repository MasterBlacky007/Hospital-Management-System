<?php
// Database connection
include "conf.php";

// Check if ID is provided
if (isset($_GET['id'])) {
    $budget_id = $_GET['id'];

    // Delete the budget
    $sql = "DELETE FROM budget WHERE budget_id = '$budget_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: bugetr.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}

$conn->close();
?>