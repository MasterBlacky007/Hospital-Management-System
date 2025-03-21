<?php
// Database connection
include "conf.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];

    $delete_sql = "DELETE FROM salaries WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Salary Delete successfully!'); window.location.href = 'salary.php';</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>