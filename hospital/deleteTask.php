<?php
// Include database connection
include "conf.php";

// Check if the task ID is provided via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = $_GET['id'];

    // Prepare and execute SQL query to delete the task
    $sql = "DELETE FROM nurse_tasks WHERE task_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $task_id);

        // Check if the deletion is successful
        if ($stmt->execute()) {
            echo "<script>
                    alert('Task deleted successfully!');
                    window.location.href = 'view_tasks.php'; // Redirect to the task list after deletion
                  </script>";
        } else {
            echo "<script>
                    alert('Error deleting task: " . $conn->error . "');
                    window.location.href = 'view_tasks.php';
                  </script>";
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "<script>
            alert('Invalid task ID!');
            window.location.href = 'view_tasks.php';
          </script>";
}

// Close the database connection
$conn->close();
?>
