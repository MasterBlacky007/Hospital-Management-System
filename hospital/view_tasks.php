<?php
// Include the database connection
include 'conf.php';

// Start the session to check for the logged-in doctor
session_start();

// Check if the doctor is logged in (assuming 'user_id' is stored in the session after login)
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'doctor') {
    die("Access denied. You must be logged in as a doctor to view the assigned tasks.");
}

$staffId = $_SESSION['user_id']; // Get the staff ID of the logged-in doctor

// SQL query to retrieve nurse tasks assigned by the logged-in doctor (staff ID)
$sql = "SELECT * FROM nurse_tasks WHERE assigned_by = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staffId);
$stmt->execute();
$result = $stmt->get_result();

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Nurse Tasks</title>
    <link rel="stylesheet" href="longtables.css">
</head>
<body>
    <div class="container">
        <h3>Nurse Task List</h3>
        <button class="add-patient" onclick="window.location.href='task_form.php'">+ Assign Task</button>
        <button class="back" onclick="window.location.href='taskdash.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <div class="main-content">
            <table id="nurseTasks">
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Nurse ID</th>
                        <th>Task Description</th>
                        <th>Assigned Date</th>
                        <th>Time</th>
                        <th>Assigned By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        // Loop through and display each task assigned to the logged-in doctor
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['task_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nurse_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['task_description']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['task_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['task_time']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['assigned_by']) . "</td>"; // This is the staff ID of the doctor
                            echo "<td>
                                    
                                    <a href='updateTask.php?id=" . htmlspecialchars($row['task_id']) . "'>Update</a> | 
                                    <a href='deleteTask.php?id=" . htmlspecialchars($row['task_id']) . "' onclick='return confirm(\"Are you sure you want to delete this task?\");'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No tasks assigned to you.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
