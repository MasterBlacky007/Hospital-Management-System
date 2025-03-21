<?php
// Include the database connection
include 'conf.php';

// Start the session to check for the logged-in nurse
session_start();

// Check if the nurse is logged in (assuming 'user_id' and 'user_role' are stored in the session after login)
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'nurse') {
    die("Access denied. You must be logged in as a nurse to view your assigned tasks.");
}

$staffId = $_SESSION['user_id']; // Get the staff ID of the logged-in nurse

// Initialize variables for date filtering
$filterDate = isset($_GET['filter_date']) ? $_GET['filter_date'] : null;

// SQL query to retrieve nurse tasks assigned to the logged-in nurse
$sql = "SELECT nt.task_id, nt.task_description, nt.task_date, nt.task_time, s.name AS assigned_by
        FROM nurse_tasks nt
        INNER JOIN staff s ON nt.assigned_by = s.id
        WHERE nt.nurse_id = (
            SELECT nurse_id FROM nurses WHERE staff_id = ?
        )";

// Add a date filter if a date is specified
if ($filterDate) {
    $sql .= " AND nt.task_date = ?";
}

$stmt = $conn->prepare($sql);
if ($filterDate) {
    $stmt->bind_param("is", $staffId, $filterDate);
} else {
    $stmt->bind_param("i", $staffId);
}
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
    <title>View My Tasks</title>
    <link rel="stylesheet" href="longtables.css">
</head>
<body>
    <div class="container">
        <h3>My Assigned Tasks</h3>
        <button class="back" onclick="window.location.href='nursedashboard.html'">Back</button>
        
        <form method="GET" action="" style="margin-bottom: 20px;">
            <label for="filter_date">Filter by Date:</label>
            <input type="date" id="filter_date" name="filter_date" value="<?= htmlspecialchars($filterDate) ?>">
            <button type="submit">Filter</button>
        </form>
        
        <div class="main-content">
            <table id="myTasks">
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Task Description</th>
                        <th>Assigned Date</th>
                        <th>Time</th>
                        <th>Assigned By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        // Loop through and display each task assigned to the logged-in nurse
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['task_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['task_description']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['task_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['task_time']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['assigned_by']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No tasks assigned to you.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
